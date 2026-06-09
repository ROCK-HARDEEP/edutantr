<?php

namespace App\Services;

use App\Enum\MediaTypeEnum;
use App\Models\SalesTeam;
use App\Repositories\MediaRepository;
use App\Repositories\UserRepository;
use App\Rules\MailRules;
use App\Rules\PhoneNumber;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserImportService
{
    private const REQUIRED_COLUMNS = ['name', 'email', 'phone', 'password'];

    public function import(UploadedFile $file): array
    {
        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return [
                'imported' => 0,
                'skipped' => 0,
                'errors' => [__('Unable to read the uploaded file.')],
            ];
        }

        $headerRow = fgetcsv($handle);

        if (!$headerRow) {
            fclose($handle);

            return [
                'imported' => 0,
                'skipped' => 0,
                'errors' => [__('The CSV file is empty.')],
            ];
        }

        $header = $this->normalizeHeader($headerRow);
        $missingColumns = array_diff(self::REQUIRED_COLUMNS, $header);

        if (!empty($missingColumns)) {
            fclose($handle);

            return [
                'imported' => 0,
                'skipped' => 0,
                'errors' => [
                    __('Missing required columns: :columns', [
                        'columns' => implode(', ', $missingColumns),
                    ]),
                ],
            ];
        }

        $organization = app()->bound('currentOrganization') ? app('currentOrganization') : null;
        $defaultProfilePicture = $this->defaultProfilePicture();

        $imported = 0;
        $skipped = 0;
        $errors = [];
        $seenEmails = [];
        $seenPhones = [];
        $lineNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $lineNumber++;

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $rowData = $this->mapRow($header, $row);
            $email = strtolower(trim($rowData['email'] ?? ''));
            $phone = trim($rowData['phone'] ?? '');

            if (isset($seenEmails[$email]) || isset($seenPhones[$phone])) {
                $skipped++;
                $errors[] = __('Row :row: Duplicate email or phone in file.', ['row' => $lineNumber]);
                continue;
            }

            $validator = Validator::make($rowData, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', new MailRules(), 'unique:users,email'],
                'phone' => ['required', 'unique:users,phone', new PhoneNumber()],
                'password' => ['required', 'min:8'],
                'team_code' => ['nullable', 'string', 'size:4'],
            ]);

            if ($validator->fails()) {
                $skipped++;
                $errors[] = __('Row :row: :message', [
                    'row' => $lineNumber,
                    'message' => implode(' ', $validator->errors()->all()),
                ]);
                continue;
            }

            $teamCode = trim($rowData['team_code'] ?? '');
            $salesTeamId = null;

            if ($teamCode !== '') {
                $salesTeamId = SalesTeam::where('code', $teamCode)
                    ->where('is_active', true)
                    ->value('id');

                if (!$salesTeamId) {
                    $skipped++;
                    $errors[] = __('Row :row: Invalid team code.', ['row' => $lineNumber]);
                    continue;
                }
            }

            $isActive = $this->parseBoolean($rowData['is_active'] ?? 'yes');

            UserRepository::create([
                'name' => trim($rowData['name']),
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($rowData['password']),
                'student_organization_id' => $organization?->id,
                'sales_team_id' => $salesTeamId,
                'media_id' => $defaultProfilePicture?->id,
                'is_active' => $isActive,
                'email_verified_at' => $isActive ? now() : null,
            ]);

            $seenEmails[$email] = true;
            $seenPhones[$phone] = true;
            $imported++;
        }

        fclose($handle);

        return compact('imported', 'skipped', 'errors');
    }

    public function sampleCsv(): string
    {
        return implode("\n", [
            'name,email,phone,password,is_active,team_code',
            'John Doe,john.doe@example.com,9876543210,Password@123,yes,',
            'Jane Smith,jane.smith@example.com,9876543211,Password@123,yes,ABCD',
            '',
        ]);
    }

    private function defaultProfilePicture()
    {
        $paths = [
            public_path('media/blank-user.png'),
            public_path('assets/images/profile/demo-profile.png'),
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return MediaRepository::storeByPath(
                    $path,
                    'user/profile_picture',
                    MediaTypeEnum::IMAGE
                );
            }
        }

        return null;
    }

    private function normalizeHeader(array $headerRow): array
    {
        $header = array_map(function ($column) {
            $column = trim((string) $column);

            if (str_starts_with($column, "\xEF\xBB\xBF")) {
                $column = substr($column, 3);
            }

            return strtolower($column);
        }, $headerRow);

        return array_values(array_filter($header, fn ($column) => $column !== ''));
    }

    private function mapRow(array $header, array $row): array
    {
        $mapped = [];

        foreach ($header as $index => $column) {
            $mapped[$column] = isset($row[$index]) ? trim((string) $row[$index]) : '';
        }

        return $mapped;
    }

    private function isEmptyRow(array $row): bool
    {
        return empty(array_filter($row, fn ($value) => trim((string) $value) !== ''));
    }

    private function parseBoolean(?string $value): bool
    {
        $value = strtolower(trim((string) $value));

        if ($value === '') {
            return true;
        }

        return in_array($value, ['1', 'yes', 'true', 'on', 'active'], true);
    }
}
