<?php

/**
 * Helper: Doctors
 * Purpose: Shared lookups for doctor profiles (includes/doctors-data.php) used by public sections, treatment
 *          pages and the dashboard Doctors pages.
 * Structure: doctor_profiles() for public rendering; doctor_patients() and doctor_treatments() for the
 *            dashboard profile summary.
 * Data: doctors keyed by doctor ID; patients from includes/dashboard-patients-data.php (doctor = doctor ID);
 *       treatments from includes/dashboard-treatments-data.php (page.doctors.ids).
 */

// Published profiles in the given order, or all published doctors when ids is null. Unknown IDs are skipped.
function doctor_profiles(array $doctors, ?array $ids = null): array
{
  $profiles = [];
  foreach ($ids ?? array_keys($doctors) as $id) {
    $doctor = $doctors[$id] ?? null;
    if ($doctor === null || ($doctor['status'] ?? 'published') !== 'published') {
      continue;
    }
    $profiles[] = [
      'id'             => $id,
      'name'           => $doctor['name'],
      'role'           => $doctor['role'] ?? '',
      'registration'   => $doctor['registration'] ?? '',
      'qualifications' => $doctor['qualifications'] ?? [],
      'image'          => $doctor['image'] ?? '',
      'image_alt'      => $doctor['image_alt'] ?? '',
    ];
  }

  return $profiles;
}

// Patients assigned to the doctor, in directory order.
function doctor_patients(array $patients, string $doctor_id): array
{
  return array_values(array_filter(
    $patients,
    static fn (array $patient): bool => ($patient['doctor'] ?? '') === $doctor_id,
  ));
}

// Treatments whose page lists the doctor, in catalogue order.
function doctor_treatments(array $treatments, string $doctor_id): array
{
  return array_values(array_filter(
    $treatments,
    static fn (array $treatment): bool => in_array($doctor_id, $treatment['page']['doctors']['ids'] ?? [], true),
  ));
}
