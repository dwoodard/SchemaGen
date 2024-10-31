# SchemaGen

SchemaGen is a package designed to parse a custom schema syntax and generate Laravel models, migrations, controllers, and Vue components. This tool allows you to centralize model and component definitions in a single file and automate code generation.

## Installation

Install via Composer:

```bash
composer require schemagen/schemagen
```

```
Summary of Symbols for Extended Laravel Features
@ - Model declaration
- - Standard properties
= - Computed properties
> - Relationships (use with(...) for filtered relationships)
? - Scopes
~ - Accessors and Mutators
% - Casts
! - Validations
$ - Observers
^ - Policies
```

Usage
Run the code generation command with your schema file:
```bash
php artisan generate:code path/to/schema.file
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

! name: required, max:255
! gender: in(m,f)

$ creating: checkUniqueName
$ deleting: logDeletion

^ view: checkViewPermission
^ update: checkUpdatePermission

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