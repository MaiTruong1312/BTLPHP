# Job Portal - Laravel Application

A comprehensive job portal application built with Laravel, featuring job postings, applications, candidate profiles, and employer management.

## Features

- **User Roles**: Candidate, Employer, and Admin
- **Job Management**: Create, edit, and manage job postings
- **Job Applications**: Candidates can apply for jobs with cover letters and CVs
- **Saved Jobs**: Candidates can save jobs for later
- **Profile Management**: Separate profiles for candidates and employers
- **Search & Filter**: Search jobs by title, category, location, and job type
- **Modern UI**: Beautiful, responsive interface built with Tailwind CSS

## Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

## Installation

1. **Clone the repository** (if applicable) or navigate to the project directory

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install Node dependencies**:
   ```bash
   npm install
   ```

4. **Configure environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Update `.env` file** with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=job_portal
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Create the database**:
   ```sql
   CREATE DATABASE job_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

7. **Run migrations**:
   ```bash
   php artisan migrate
   ```

8. **Seed the database** (optional, for sample data):
   ```bash
   php artisan db:seed
   ```

9. **Create storage link**:
   ```bash
   php artisan storage:link
   ```

10. **Build frontend assets**:
    ```bash
    npm run build
    ```

11. **Start the development server**:
    ```bash
    php artisan serve
    ```

12. **Visit the application**:
    Open your browser and go to `http://localhost:8000`

## Default Login Credentials

After running the seeder, you can use these credentials:

**Admin:**
- Email: `admin@example.com`
- Password: `password`

**Employer:**
- Email: `employer@example.com`
- Password: `password`

**Candidate:**
- Email: `candidate@example.com`
- Password: `password`

## Database Structure

The application includes the following main tables:

- `users` - User accounts with role-based access
- `candidate_profiles` - Candidate information
- `employer_profiles` - Employer/company information
- `jobs` - Job postings
- `job_applications` - Job applications
- `saved_jobs` - Saved jobs by candidates
- `job_categories` - Job categories
- `job_locations` - Job locations
- `skills` - Skills database
- `job_skill` - Job-skill pivot table
- `candidate_skill` - Candidate-skill pivot table
- `candidate_experiences` - Work experience
- `candidate_educations` - Education history

## Usage

### For Candidates:
1. Register/Login as a candidate
2. Complete your profile
3. Browse and search for jobs
4. Apply for jobs with cover letter and CV
5. Save jobs for later
6. Track your applications

### For Employers:
1. Register/Login as an employer
2. Complete company profile
3. Post job openings
4. Manage job postings
5. View applications

### For Admins:
1. Login as admin
2. Access admin dashboard
3. Manage all jobs and users

## Development

To run the development server with hot reload:

```bash
npm run dev
php artisan serve
```

## License

This project is open-sourced software licensed under the MIT license.
