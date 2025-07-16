# IRIS (Interactive Recruitment Information System)

#### Installing laravel breeze

composer require laravel/breeze --dev

php artisan breeze:install blade

#### Creating Job Openings

php artisan make:model JobOpening -m

php artisan make:factory JobOpeningFactory

php artisan make:seeder JobOpening Seeder

php artisan migrate:fresh --seed

php artisan make:controller JobOpeningController --resource

#### Tailwind config file

npm install -D tailwindcss postcss autoprefixer

npx tailwindcss init

#### Creating event for checking jobs' status

php artisan make:event JobExpiryCheckRequested

php artisan make:listener UpdateJobStatusOnExpiry

php artisan make:event CheckAllJobsForExpiry

php artisan make:listener UpdateAllJobStatuses

#### Creating Applicants

php artisan make:model Applicant -mfsc --resource

php artisan migrate

php artisan storage:link

#### Creating applications

php artisan make:migration create_job_opening_applicat

php artisan migrate

php artisan make:seeder ApplicantSeeder

#### Creating finance records / application fee

php artisan make:model ApplicationFee -mfsc --resource

#### Reports

php artisan make:controller ReportController

#### Login user, register user, create user, delete user

php artisan make:migration add_role_to_users

#### Logging user logins

php artisan make:migration create_login_events_table

php artisan make:model LoginEvent

php artisan make:listener LogSuccessfulLogin --event=Illuminate\Auth\Events\Login

#### Logging admin actions

php artisan make:model AdminActionLog

#### Educational Attainment

php artisan make:migration create_educational_attainments_table

php artisan make:controller EducationalAttainmentControler --resource

#### Work Experience

php artisan make:migration create_work_experiences_table

php artisan make:model WorkExperience

php artisan make:controller WorkExperienceController

#### References

php artisan make:migration create_references_table

php artisan make:model Reference

php artisan make:controller ReferenceController