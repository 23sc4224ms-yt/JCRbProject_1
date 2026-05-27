# Professional Student Portal - CSS Components Guide

## Overview
This is a comprehensive pure CSS design system for the Student Portal using **DM Sans** typography and a professional enterprise-grade aesthetic. All styles are embedded in `resources/views/layouts/app.blade.php`.

---

## Color Palette

```css
/* Primary Colors */
--color-primary: #1e3a5f        /* Deep Navy Blue */
--color-accent: #2563eb         /* Electric Blue */
--color-success: #059669        /* Emerald */
--color-warning: #d97706        /* Amber */
--color-danger: #dc2626         /* Red */

/* Backgrounds & Surfaces */
--color-bg: #f1f5f9             /* Cool Light Gray */
--color-surface: #ffffff        /* White */
--color-border: #e2e8f0         /* Soft Dividers */

/* Text */
--color-text: #0f172a           /* Near Black */
--color-text-muted: #64748b     /* Slate Gray */
```

---

## Layout Components

### 1. Navbar

**Usage in Blade:**
```blade
<nav class="navbar">
    <a href="/" class="navbar-brand">Student Portal</a>
    <ul class="navbar-nav">
        <li><a href="/home" class="nav-link active">Home</a></li>
        <li><a href="/students" class="nav-link">Students</a></li>
    </ul>
</nav>
```

**Features:**
- Height: 56px
- Sticky positioning, minimal shadow
- Brand has blue accent dot
- Navigation links have active state highlighting

---

## Page Structure

### Page Header

**Usage:**
```blade
<div class="page-header mb-4">
    <div>
        <h1 class="page-header-title">Dashboard</h1>
        <p class="page-header-subtitle">Student enrollment overview</p>
    </div>
    <a href="#" class="btn btn-primary">Add Student</a>
</div>
```

**Features:**
- Space-between layout for title + button
- Subtitle in muted color
- Responsive: stacks on mobile

---

## Cards

### Basic Card

```blade
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Card Title</h2>
    </div>
    <div class="card-body">
        <!-- Content here -->
    </div>
</div>
```

**Features:**
- 1px border, soft shadow
- Padding: 1.5rem
- Border radius: 10px

---

## Tables

### Table with Compact Style

```blade
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
                <tr>
                    <td>Data</td>
                    <td>Data</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn btn-sm btn-secondary">View</a>
                            <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

**Features:**
- Header: uppercase labels (0.7rem), muted color, light gray background
- Row height: 44px
- Compact padding: 0.6rem 1rem
- Hover effect: light background
- Border only between rows

---

## Buttons

### Button Styles

```blade
<!-- Primary (Deep Navy) -->
<a href="#" class="btn btn-primary">Save</a>

<!-- Secondary (Light Gray) -->
<a href="#" class="btn btn-secondary">Cancel</a>

<!-- Success (Emerald) -->
<button class="btn btn-success">Confirm</button>

<!-- Danger (Red) -->
<button class="btn btn-danger">Delete</button>

<!-- Warning (Amber) -->
<button class="btn btn-warning">Warn</button>

<!-- Small Button -->
<a href="#" class="btn btn-sm btn-secondary">View</a>

<!-- Full Width -->
<button class="btn btn-primary btn-block">Submit Form</button>
```

**Features:**
- Border radius: 6px
- Padding: 0.45rem 1rem (sm: 0.35rem 0.75rem)
- Font: 0.8rem, weight 600
- Flat style, no shadow
- 0.15s smooth transition on hover
- Icons work with `<i class="fas fa-*"></i>`

---

## Badges

### Badge Types

```blade
<span class="badge badge-blue">In Progress</span>
<span class="badge badge-green">Active</span>
<span class="badge badge-gray">Inactive</span>
<span class="badge badge-danger">Critical</span>
<span class="badge badge-warning">Pending</span>
```

**Features:**
- Pill shape (border-radius: 999px)
- Padding: 0.2rem 0.6rem
- Font: 0.72rem, weight 600
- Color combinations defined per type

---

## Forms

### Form Group

```blade
<div class="form-group">
    <label for="email" class="form-label">Email Address</label>
    <input 
        type="email" 
        class="form-control" 
        id="email" 
        name="email"
        placeholder="your@email.com"
        required>
</div>
```

**Features:**
- Label: 0.78rem, uppercase, muted, weight 600
- Input height: 38px
- Border: 1.5px solid
- Focus: blue border + subtle blue shadow
- Border radius: 6px

### Multi-Column Form Layout

```blade
<!-- 3-Column Row -->
<div class="form-row form-row-3">
    <div class="form-group">
        <label class="form-label">First Name</label>
        <input type="text" class="form-control" placeholder="John">
    </div>
    <div class="form-group">
        <label class="form-label">Middle Name</label>
        <input type="text" class="form-control" placeholder="Michael">
    </div>
    <div class="form-group">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-control" placeholder="Doe">
    </div>
</div>

<!-- 2-Column Row -->
<div class="form-row form-row-2">
    <div class="form-group">
        <label class="form-label">Age</label>
        <input type="number" class="form-control" placeholder="19">
    </div>
    <div class="form-group">
        <label class="form-label">Degree</label>
        <select class="form-control">
            <option>Select...</option>
        </select>
    </div>
</div>
```

**Features:**
- Auto-responsive grid
- Stacks to 1 column on mobile (<768px)
- Gap: 1.25rem

### Select Element

```blade
<select class="form-control">
    <option>-- Select Option --</option>
    @foreach($items as $item)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endforeach
</select>
```

**Features:**
- Same styling as input
- Cursor pointer

### Form Error Display

```blade
<div class="form-group">
    <label class="form-label">Email</label>
    <input 
        type="email" 
        class="form-control @error('email') is-invalid @enderror"
        name="email"
        value="{{ old('email') }}">
    @error('email')
        <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">
            {{ $message }}
        </span>
    @enderror
</div>
```

---

## Alerts / Flash Messages

### Success Alert

```blade
<div class="alert alert-success" role="alert">
    <i class="fas fa-check-circle"></i> Student saved successfully!
</div>
```

### Error Alert

```blade
<div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-circle"></i> Please fix the errors below.
</div>
```

### Warning Alert

```blade
<div class="alert alert-warning" role="alert">
    <i class="fas fa-triangle-exclamation"></i> This action cannot be undone.
</div>
```

### Info Alert

```blade
<div class="alert alert-info" role="alert">
    <i class="fas fa-info-circle"></i> Additional information.
</div>
```

**Features:**
- Left border: 3px colored
- Compact padding: 0.65rem 1rem
- Font size: 0.85rem
- Background colors defined per type

---

## Detail View (Show Page)

### Detail Grid Layout

```blade
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Personal Information</h2>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div>
                <div class="detail-row">
                    <div class="detail-label">Student ID</div>
                    <div class="detail-value">12345</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Age</div>
                    <div class="detail-value">21</div>
                </div>
            </div>
            
            <div>
                <div class="detail-row">
                    <div class="detail-label">Program</div>
                    <div class="detail-value">
                        <span class="badge badge-blue">BSIT</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

**Features:**
- 2-column layout (auto-responsive)
- Label: uppercase, small, muted
- Value: normal weight, dark color
- Row dividers with borders
- Mobile: stacks to 1 column

---

## Empty States

### Empty State Component

```blade
<div class="empty-state">
    <div class="empty-state-icon">👥</div>
    <h2 class="empty-state-title">No Students Found</h2>
    <p class="empty-state-text">Start by adding your first student to the system</p>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Student
    </a>
</div>
```

**Features:**
- Center aligned
- Icon (emoji or icon at top)
- Title, description, CTA button
- Padding: 3rem
- Works in cards or standalone

---

## Pagination

### Pagination Component

```blade
<ul class="pagination">
    <li><a href="#">← Previous</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li class="active"><span>3</span></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">Next →</a></li>
</ul>
```

**Features:**
- Centered flex layout
- Each item: 32×32px, border-radius 6px
- Active: navy background, white text
- Inactive: light gray background, slate text
- Hover: darker background

---

## Action Groups

### Button Groups

```blade
<div class="actions">
    <a href="#" class="btn btn-primary">Save</a>
    <a href="#" class="btn btn-secondary">Cancel</a>
    <a href="#" class="btn btn-danger btn-sm">Delete</a>
</div>
```

**Features:**
- Flex layout with gap
- Responsive: wraps on mobile

### Table Row Actions

```blade
<td>
    <div class="actions">
        <a href="#" class="btn btn-sm btn-secondary">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="#" class="btn btn-sm btn-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</td>
```

---

## Utility Classes

### Spacing

```blade
<!-- Margin Top -->
<div class="mt-1">...</div>      <!-- 0.5rem -->
<div class="mt-2">...</div>      <!-- 1rem -->
<div class="mt-3">...</div>      <!-- 1.5rem -->
<div class="mt-4">...</div>      <!-- 2rem -->

<!-- Margin Bottom -->
<div class="mb-1">...</div>
<div class="mb-2">...</div>
<div class="mb-3">...</div>
<div class="mb-4">...</div>
```

### Flexbox

```blade
<div class="flex">...</div>              <!-- display: flex -->
<div class="flex-center">...</div>      <!-- centered both ways -->
<div class="flex-between">...</div>     <!-- space-between -->
```

### Text Color

```blade
<p class="text-muted">Muted text</p>
<p class="text-danger">Error text</p>
<p class="text-success">Success text</p>
```

---

## Complete Page Example

### Students Index Page

```blade
@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Students</h1>
            <p class="page-header-subtitle">Complete list of enrolled students</p>
        </div>
        <a href="/students/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Student
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    @if($students->count() > 0)
        <div class="card">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Program</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td><strong>{{ $student->id }}</strong></td>
                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                <td>{{ $student->age }}</td>
                                <td>
                                    <span class="badge badge-blue">
                                        {{ $student->degree->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="/students/{{ $student->id }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/students/{{ $student->id }}/edit" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h2 class="empty-state-title">No Students</h2>
            <p class="empty-state-text">Add your first student to get started</p>
            <a href="/students/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Student
            </a>
        </div>
    @endif
@endsection
```

---

## Responsive Design

### Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px  
- Desktop: > 1024px

### Key Responsive Changes
- Forms: stack from 3-col → 2-col → 1-col
- Layout: max-width 1080px centered
- Navbar: compresses on mobile
- Buttons: full-width on mobile when in `.actions`

---

## Typography Scale

- **Page Title**: 1.25rem, weight 700, letter-spacing -0.02em
- **Card Title**: 1rem, weight 700
- **Body Text**: 0.875rem, line-height 1.6
- **Label**: 0.78rem, uppercase, weight 600
- **Table Header**: 0.7rem, uppercase, weight 600

---

## Spacing Scale

```
4px, 8px, 12px, 16px, 24px, 32px, etc.
```

Applied as:
- Card padding: 1.5rem (24px)
- Form gap: 1.25rem (20px)
- Table cells: 0.6rem 1rem (10px 16px)
- Button padding: 0.45rem 1rem (7px 16px)

---

## Interactive Effects

- **Transitions**: 0.15s ease on all interactive elements
- **Button Hover**: 8% color darken
- **Input Focus**: Blue border + blue shadow (10% opacity)
- **Table Hover**: Light gray background
- **Link Hover**: Underline (if applicable)

---

## Notes for Development

1. **Always use CSS var()**: Reference the color palette via CSS variables
2. **Maintain spacing scale**: Use consistent multiples of base unit
3. **Semantic HTML**: Use proper form elements, labels, and accessibility attributes
4. **Mobile-first**: Ensure responsive design works on all devices
5. **Blade directives**: Utilize @error, @csrf, @method for forms
6. **Error states**: Show validation errors consistently
7. **Icons**: Use Font Awesome 6.5.0 with `<i class="fas fa-*"></i>`

---

## Files to Reference

- **Layout**: `resources/views/layouts/app.blade.php`
- **Example Pages**: 
  - `resources/views/home.blade.php` (Index)
  - `resources/views/studentDetails.blade.php` (Show)
  - `resources/views/addstudent.blade.php` (Create)
  - `resources/views/editstudent.blade.php` (Edit)
