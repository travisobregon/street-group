## Homeowner Names - Technical Test

### Overview

This application processes a CSV file containing homeowner data, splits names into individual person records, and stores them in the database. The system adheres to the following schema for person records:

#### Person Schema

- `title` - required
- `first_name` - optional
- `initial` - optional
- `last_name` - required

### Features

- **CSV Parsing**: Load and parse CSV files containing homeowner data.
- **Name Splitting**: Split names into individual person records.
- **Data Storage**: Store person records in the database with the required schema.
- **Pagination**: Paginate the list of homeowners for better performance and user experience.

### Suggested Improvements

If there was more time, the following improvements could be made:

1. **Improve TypeScript Support**:
   - Make use of `spatie/laravel-typescript-transformer` and `spatie/laravel-data` to enhance TypeScript support in the project.

2. **AI-Powered CSV Parsing**:
   - Use AI to parse the CSV and map content to the relevant parts adhering to the schema. This approach can handle more edge cases and would be a good use case for AI.

3. **Laravel Macro/Mixin**:
   - Consider using a Laravel macro/mixin on `Str` instead of an action class for name splitting. The downside is the potential loss of IDE support.

4. **Static Analysis**:
   - Integrate `Larastan`/`PHPStan` for static analysis to catch potential issues early and improve code quality.

5. **Enhanced Table Components**:
   - Consider using [Tanstack Table](https://tanstack.com/table/latest) or [Inertia Table](https://inertiaui.com/inertia-table) for better table management and UI components.

6. **Improved Error Handling and Validation**:
   - Enhance error handling and validation for file uploads. Implement a system similar to [Filament's import action](https://filamentphp.com/docs/3.x/actions/prebuilt-actions/import), where users can download a CSV containing errors if any rows fail validation. Additionally, queue imports for better performance and reliability.

7. **Idempotent Import Jobs**:
   - Implement a unique way to identify records to ensure that import jobs are idempotent, preventing duplicate entries.

8. **Updated Auth Screens**:
   - Update authentication screens from Breeze defaults to match Shdacn components for a consistent and modern UI.

### Installation

1. Clone the repository:
```sh
   git clone https://github.com/travisobregon/street-group.git
   cd street-group
```

1. Install dependencies 
```sh
composer install
npm install
```

1. Run migrations
```sh
php artisan migrate
```

1. Run app
```sh
composer run dev
```