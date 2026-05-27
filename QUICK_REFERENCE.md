# Student Portal - Quick Reference Cheat Sheet

## Navbar Active State

To highlight current page in navbar:
```blade
<a href="{{ url('/students') }}" 
   class="nav-link @if(request()->is('students*')) active @endif">
    Students
</a>
```

---

## Common Page Patterns

### List View (Index)
```blade
@extends('layouts.app')
@section('title', 'Students')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-header-title">Students</h1>
        <p class="page-header-subtitle">All enrolled students</p>
    </div>
    <a href="{{ url('/students/create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add
    </a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->field1 }}</td>
                        <td>{{ $item->field2 }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ url('/students/' . $item->id) }}" class="btn btn-sm btn-secondary">View</a>
                                <a href="{{ url('/students/' . $item->id . '/edit') }}" class="btn btn-sm btn-secondary">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
```

### Create/Edit Form
```blade
@extends('layouts.app')
@section('title', 'Add Student')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-header-title">Add Student</h1>
        <p class="page-header-subtitle">Enroll new student</p>
    </div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <h2 class="card-title">Student Details</h2>
    </div>
    <div class="card-body">
        <form action="{{ url('/students') }}" method="POST">
            @csrf

            <!-- 3-Column Row -->
            <div class="form-row form-row-3">
                <div class="form-group">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control @error('fname') is-invalid @enderror" 
                           name="fname" id="fname" value="{{ old('fname') }}" required>
                    @error('fname')<span class="text-danger" style="font-size: 0.75rem;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="mname" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="mname" id="mname" value="{{ old('mname') }}">
                </div>
                <div class="form-group">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control @error('lname') is-invalid @enderror" 
                           name="lname" id="lname" value="{{ old('lname') }}" required>
                    @error('lname')<span class="text-danger" style="font-size: 0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <!-- 2-Column Row -->
            <div class="form-row form-row-2">
                <div class="form-group">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" name="age" id="age" value="{{ old('age') }}" required>
                </div>
                <div class="form-group">
                    <label for="degree_id" class="form-label">Program</label>
                    <select class="form-control" name="degree_id" id="degree_id" required>
                        <option>Select...</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="actions mt-4">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
                <a href="{{ url('/students') }}" class="btn btn-secondary btn-block">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
```

### Show/Detail View
```blade
@extends('layouts.app')
@section('title', 'Student Details')
@section('content')

<div class="page-header mb-4">
    <div>
        <h1 class="page-header-title">Student Details</h1>
    </div>
    <div class="actions">
        <a href="{{ url('/students/' . $student->id . '/edit') }}" class="btn btn-primary">Edit</a>
        <a href="{{ url('/students') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Information</h2>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div>
                <div class="detail-row">
                    <div class="detail-label">Student ID</div>
                    <div class="detail-value">{{ $student->id }}</div>
                </div>
            </div>
            <div>
                <div class="detail-row">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $student->fname }} {{ $student->lname }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
```

---

## Button Classes

```blade
<!-- Variants -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-warning">Warning</button>

<!-- Sizes -->
<button class="btn btn-sm btn-primary">Small</button>
<button class="btn btn-primary">Normal</button>

<!-- Full Width -->
<button class="btn btn-primary btn-block">Block</button>

<!-- With Icons -->
<button class="btn btn-primary">
    <i class="fas fa-save"></i> Save
</button>
```

---

## Badge Classes

```blade
<span class="badge badge-blue">Active</span>
<span class="badge badge-green">Complete</span>
<span class="badge badge-gray">Inactive</span>
<span class="badge badge-danger">Error</span>
<span class="badge badge-warning">Pending</span>
```

---

## Alert Classes

```blade
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> Success!
</div>

<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> Error!
</div>

<div class="alert alert-warning">
    <i class="fas fa-triangle-exclamation"></i> Warning!
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Info!
</div>
```

---

## Form Examples

### Text Input with Error
```blade
<div class="form-group">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" 
           name="email" id="email" value="{{ old('email') }}" placeholder="user@example.com">
    @error('email')
        <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">
            {{ $message }}
        </span>
    @enderror
</div>
```

### Select Dropdown
```blade
<div class="form-group">
    <label for="degree_id" class="form-label">Degree</label>
    <select class="form-control" name="degree_id" id="degree_id" required>
        <option value="">Select a degree...</option>
        @foreach($degrees as $degree)
            <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                {{ $degree->name }}
            </option>
        @endforeach
    </select>
</div>
```

### Textarea
```blade
<div class="form-group">
    <label for="notes" class="form-label">Notes</label>
    <textarea class="form-control" name="notes" id="notes" rows="4" placeholder="Enter notes..."></textarea>
</div>
```

### Checkbox/Radio
```blade
<div class="form-group">
    <label for="active" style="display: flex; align-items: center; gap: 0.5rem;">
        <input type="checkbox" id="active" name="active" value="1">
        <span>Mark as active</span>
    </label>
</div>
```

---

## Utility Classes

```blade
<!-- Margin -->
<div class="mt-1"></div>  <!-- margin-top: 0.5rem -->
<div class="mt-2"></div>  <!-- margin-top: 1rem -->
<div class="mt-3"></div>  <!-- margin-top: 1.5rem -->
<div class="mt-4"></div>  <!-- margin-top: 2rem -->
<div class="mb-1"></div>  <!-- margin-bottom: 0.5rem -->
<div class="mb-2"></div>  <!-- margin-bottom: 1rem -->
<div class="mb-3"></div>  <!-- margin-bottom: 1.5rem -->
<div class="mb-4"></div>  <!-- margin-bottom: 2rem -->

<!-- Gap -->
<div class="gap-1"></div> <!-- gap: 0.5rem -->
<div class="gap-2"></div> <!-- gap: 1rem -->

<!-- Flexbox -->
<div class="flex">Content</div>              <!-- display: flex -->
<div class="flex-center">Content</div>      <!-- centered both ways -->
<div class="flex-between">Left|Right</div>  <!-- space-between -->

<!-- Text Color -->
<p class="text-muted">Muted text</p>
<p class="text-danger">Error text</p>
<p class="text-success">Success text</p>
```

---

## Empty State

```blade
<div class="empty-state">
    <div class="empty-state-icon">📋</div>
    <h2 class="empty-state-title">No Data</h2>
    <p class="empty-state-text">Description of empty state</p>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New
    </a>
</div>
```

---

## Common Icons (Font Awesome)

```
<!-- Navigation -->
<i class="fas fa-house"></i>           <!-- Home -->
<i class="fas fa-users"></i>           <!-- Users -->
<i class="fas fa-graduation-cap"></i>  <!-- Graduation -->
<i class="fas fa-circle-info"></i>     <!-- Info -->

<!-- Actions -->
<i class="fas fa-plus"></i>            <!-- Add -->
<i class="fas fa-eye"></i>             <!-- View -->
<i class="fas fa-edit"></i>            <!-- Edit -->
<i class="fas fa-trash"></i>           <!-- Delete -->
<i class="fas fa-save"></i>            <!-- Save -->
<i class="fas fa-times"></i>           <!-- Close -->
<i class="fas fa-arrow-left"></i>      <!-- Back -->

<!-- Status -->
<i class="fas fa-check-circle"></i>        <!-- Success -->
<i class="fas fa-exclamation-circle"></i>  <!-- Error -->
<i class="fas fa-triangle-exclamation"></i><!-- Warning -->
<i class="fas fa-info-circle"></i>         <!-- Info -->
```

---

## Common Blade Patterns

### Displaying Related Data
```blade
<td>
    @if($student->degree)
        <span class="badge badge-blue">{{ $student->degree->name }}</span>
    @else
        <span class="badge badge-gray">Unassigned</span>
    @endif
</td>
```

### Loop with Actions
```blade
@forelse($students as $student)
    <tr>
        <td>{{ $student->id }}</td>
        <td>{{ $student->name }}</td>
        <td>
            <div class="actions">
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-secondary">View</a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-secondary">Edit</a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" style="text-align: center; padding: 2rem;">
            No students found
        </td>
    </tr>
@endforelse
```

### Form Method Spoofing (PUT/DELETE)
```blade
<form action="{{ url('/students/' . $student->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- Form content -->
</form>
```

### Old Value Preservation
```blade
<input type="text" class="form-control" name="fname" value="{{ old('fname', $student->fname ?? '') }}" required>
```

---

## File Organization

```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php          ← Master layout with all CSS
│   ├── home.blade.php             ← Index/dashboard
│   ├── students.blade.php         ← Student list
│   ├── studentDetails.blade.php   ← Student show
│   ├── addstudent.blade.php       ← Student create
│   ├── editstudent.blade.php      ← Student edit
│   └── degrees/                   ← Degree pages (similar pattern)
└── css/
    └── app.css                    ← Import only

CSS_COMPONENTS_GUIDE.md            ← Full documentation
```

---

## Tips & Tricks

1. **Always use `.btn-block` for full-width buttons** in forms/actions
2. **Use `.mb-4` after page headers** for consistent spacing
3. **Wrap tables in `.table-wrapper`** for proper styling
4. **Use `.detail-grid` for 2-column field display** on show pages
5. **Use `.form-row-3` for 3-column name fields**, `.form-row-2` for 2-column
6. **Show errors under inputs** with max `font-size: 0.75rem`
7. **Always include a back button** or cancel option
8. **Use badges for status/category display** instead of plain text
9. **Wrap small buttons in `<div class="actions">`** for proper spacing
10. **Use `@error()` directive** to show validation errors

---

## Colors Reference

```blade
<!-- As CSS variables -->
--color-primary: #1e3a5f          <!-- Use for primary buttons -->
--color-accent: #2563eb           <!-- Use for highlights -->
--color-success: #059669          <!-- Use for positive actions -->
--color-warning: #d97706          <!-- Use for cautions -->
--color-danger: #dc2626           <!-- Use for destructive actions -->
--color-bg: #f1f5f9               <!-- Page background -->
--color-surface: #ffffff          <!-- Card/form backgrounds -->
--color-border: #e2e8f0           <!-- Dividers -->
--color-text: #0f172a             <!-- Main text -->
--color-text-muted: #64748b       <!-- Secondary text -->

<!-- Direct color usage -->
class="text-success"  <!-- Green text -->
class="text-danger"   <!-- Red text -->
class="text-muted"    <!-- Gray text -->
```

---

*Last Updated: 2026-03-19*
*Design System Version: 1.0*
