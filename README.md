# SchemaGen

SchemaGen is a package designed to parse a custom schema syntax and generate Laravel models, migrations, controllers, and Vue components. This tool allows you to centralize model and component definitions in a single file and automate code generation.

## Installation

Install via Composer:

```bash
composer require dwoodard/schemagen
```

```
Summary of Symbols for Extended Laravel Features
@           - Model declaration
-           - Standard properties (Fillable in Model, Used in Seeder and Factory
-&          - placeholders for AI-generated content (ai_ suffix in DB, nullable to start)
=           - Computed properties
>           - Relationships (use with(...) for filtered relationships)
?           - Scopes - used to define query scopes
~           - Accessors and Mutators (getters and setters)
%           - Casts (casts property to specified type)
!           - Validations (required, max, min, etc.)
@Job        - Specifies background tasks to be run asynchronously
@Event      - Defines events that trigger real-time updates or actions
@Listener   - Defines listeners that respond to events
@Component  - Creates Vue components with properties and methods
@Event - Defines events that can trigger actions or real-time updates
```

Usage
create the schema file call schema.lsd (Laravel Schema Definitions) with the following command:
```bash
# If no schema file is specified, `schema.lsd` will be used as the default.
php artisan generate:schema [database/schemas/schema.lsd]
```

## Example Schema
```
@ Dog

- id: integer, primary_key
- name: string, required
- birthday: date
- breed: string
- gender: enum(m,f), required

= age: integer -> calculate based on birthday
= is_puppy: boolean -> check if age < 1

> toys: hasMany(Toy)
> owner: belongsTo(User)
> active_toys: hasMany(Toy) with(status = active)

? puppies -> where age < 1
? adults -> where age >= 1

~ full_name: string -> concatenate first_name and last_name
~ birth_year: integer -> extract year from birthday

% age: integer
% birthday: datetime

! name: 
    required -> name is required
    max:255 -> name must be less than 255 characters
    unique -> name must be unique
! gender: in(m,f)
! birthday: required, date
! breed: max:50
! age: integer

$ creating: checkUniqueName
$ deleting: logDeletion

^ view: checkViewPermission
^ update: checkUpdatePermission

@Job DogCleanup -> clean up old dog records
@Event DogCreated -> emit when dog is created
@Listener DogCreatedListener -> listen for DogCreated event

@Component DogProfile

---

@Component DogProfile

- name: string, required
- breed: string
= formattedAge -> format age as "2 years, 3 months"
= isPuppyStatus -> return "Puppy" if age < 1, else "Adult"

$ showDetails: boolean -> initial value: false

~ toggleDetails -> toggles showDetails
~ fetchDogInfo -> fetches additional dog data from API

! dogSelected: emits event when dog is selected

```
