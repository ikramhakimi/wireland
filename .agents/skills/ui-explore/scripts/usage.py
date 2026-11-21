"""Token usage summary for the current Claude Code session, read from its transcript (no estimation).

Usage (from the project root):
  python3 -I .agents/skills/ui-explore/scripts/usage.py [--turns N | --since-text TEXT] [--full]

  --turns N         count from the Nth most recent user message (default 1: this run's request)
  --since-text TEXT count from the latest user message containing TEXT
  --full            list every tool instead of the top 3

Columns: new_input = fresh input (tool results, files read, new prompt); output = written tokens incl.
thinking; cache_read = context re-read from cache on each call (much cheaper per token). A message that
calls several tools at once is counted under its first tool. Subagent transcripts are not included.
"""

import collections
import json
import os
import sys


def find_transcript():
    slug    = os.getcwd().replace('/', '-')
    project = os.path.expanduser('~/.claude/projects/' + slug)
    files   = [os.path.join(project, f) for f in os.listdir(project) if f.endswith('.jsonl')]
    return max(files, key=os.path.getmtime)


def is_user_prompt(record):
    if record.get('type') != 'user':
        return False
    content = record.get('message', {}).get('content')
    if isinstance(content, str):
        return True
    return any(isinstance(c, dict) and c.get('type') == 'text' for c in content or [])


def start_time(records, turns, since_text):
    prompts = [r for r in records if is_user_prompt(r)]
    if since_text:
        prompts = [r for r in prompts if since_text in json.dumps(r.get('message', {}), ensure_ascii=False)]
        return prompts[-1]['timestamp'] if prompts else None
    return prompts[-turns]['timestamp'] if len(prompts) >= turns else None


def main():
    args       = sys.argv[1:]
    turns      = int(args[args.index('--turns') + 1]) if '--turns' in args else 1
    since_text = args[args.index('--since-text') + 1] if '--since-text' in args else ''
    full       = '--full' in args
    records    = []

    for line in open(find_transcript(), encoding='utf-8'):
        try:
            records.append(json.loads(line))
        except ValueError:
            continue

    since = start_time(records, turns, since_text)
    if since is None:
        print('No matching user message found.')
        return

    messages = {}
    for record in records:
        if record.get('type') != 'assistant' or record.get('timestamp', '') < since:
            continue
        message = record.get('message', {})
        entry   = messages.setdefault(message.get('id'), {'usage': {}, 'tools': []})
        entry['usage']  = message.get('usage') or entry['usage']
        entry['tools'] += [c.get('name', '') for c in message.get('content', [])
                           if isinstance(c, dict) and c.get('type') == 'tool_use']

    total, by_tool = collections.Counter(), collections.defaultdict(collections.Counter)
    for entry in messages.values():
        usage = entry['usage']
        name  = entry['tools'][0] if entry['tools'] else 'reply'
        name  = name.replace('mcp__playwright__browser_', 'browser:')
        row   = {
            'calls':      1,
            'new_input':  usage.get('input_tokens', 0) + usage.get('cache_creation_input_tokens', 0),
            'output':     usage.get('output_tokens', 0),
            'cache_read': usage.get('cache_read_input_tokens', 0),
        }
        total.update(row)
        by_tool[name].update(row)

    print(f"Tokens: {total['new_input'] + total['output']:,} new ({total['new_input']:,} input + "
          f"{total['output']:,} output) · {total['cache_read']:,} cache read · {total['calls']} calls")
    ranked = sorted(by_tool.items(), key=lambda item: -(item[1]['new_input'] + item[1]['output']))
    for name, row in ranked if full else ranked[:3]:
        print(f"  {name:<20} {row['new_input'] + row['output']:>8,} new  ({row['calls']} calls)")


main()
