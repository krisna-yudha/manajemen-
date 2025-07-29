# API Documentation - User Management System

## Authentication
All protected routes require Bearer token authentication using Laravel Sanctum.

Add header: `Authorization: Bearer {your_token_here}`

## User Management API Endpoints

### Base URL: `/api`

### 1. Get All Users
**GET** `/api/users`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Query Parameters:**
- `role` (optional): Filter by role (`member`, `gudang`, `manager`)
- `status` (optional): Filter by status (`active`, `inactive`) 
- `search` (optional): Search by name or email
- `page` (optional): Page number for pagination

**Response:**
```json
{
    "status": "success",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "role": "member",
                "is_active": true,
                "created_at": "2025-01-01T00:00:00.000000Z",
                "updated_at": "2025-01-01T00:00:00.000000Z"
            }
        ],
        "per_page": 15,
        "total": 1
    }
}
```

### 2. Get Single User
**GET** `/api/users/{id}`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Response:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "member",
        "is_active": true,
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### 3. Create User
**POST** `/api/users`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "role": "member"
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, string, email, max:255, unique:users
- `password`: required, string, min:6
- `role`: required, in:member,gudang,manager

**Response:**
```json
{
    "status": "success",
    "message": "User created successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "member",
        "is_active": true,
        "created_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### 4. Update User
**PUT** `/api/users/{id}`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Request Body:**
```json
{
    "name": "John Doe Updated",
    "email": "john.updated@example.com",
    "password": "newpassword123",
    "role": "gudang"
}
```

**Note:** Password is optional in update

**Response:**
```json
{
    "status": "success",
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "name": "John Doe Updated",
        "email": "john.updated@example.com",
        "role": "gudang",
        "is_active": true,
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

### 5. Toggle User Status (Activate/Deactivate)
**PATCH** `/api/users/{id}/toggle-status`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Response:**
```json
{
    "status": "success",
    "message": "User deactivated successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "member",
        "is_active": false,
        "updated_at": "2025-01-01T00:00:00.000000Z"
    }
}
```

**Note:** Cannot deactivate manager users - will return 403 error

### 6. Delete User
**DELETE** `/api/users/{id}`

**Middleware:** `auth:sanctum`, `active`, `role:manager,gudang`

**Response:**
```json
{
    "status": "success",
    "message": "User deleted successfully"
}
```

**Note:** Cannot delete manager users - will return 403 error

### 7. Dashboard Statistics
**GET** `/api/dashboard/stats`

**Middleware:** `auth:sanctum`, `active`, `role:manager`

**Response:**
```json
{
    "status": "success",
    "data": {
        "stats": {
            "total_users": 10,
            "active_users": 8,
            "inactive_users": 2,
            "total_barangs": 50,
            "total_rentals": 25,
            "pending_rentals": 5,
            "ongoing_rentals": 10,
            "available_barangs": 40,
            "low_stock_barangs": 5,
            "out_of_stock_barangs": 5
        },
        "recent_rentals": [...],
        "low_stock_items": [...]
    }
}
```

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden (Manager Protection)
```json
{
    "status": "error",
    "message": "Cannot deactivate manager users"
}
```

### 404 Not Found
```json
{
    "status": "error",
    "message": "User not found"
}
```

### 422 Validation Error
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

## New Features Added

1. **User Status Management**: Added `is_active` field to track user activation status
2. **Toggle Status API**: New endpoint to activate/deactivate users
3. **Manager Protection**: Cannot deactivate or delete manager users
4. **Status Filtering**: Filter users by active/inactive status
5. **Enhanced Statistics**: Dashboard now shows active/inactive user counts
6. **Middleware Protection**: Inactive users are automatically blocked from API access

## Usage Examples

### Filter active users only:
```
GET /api/users?status=active
```

### Search for users with role filter:
```
GET /api/users?role=member&search=john
```

### Toggle user status:
```
PATCH /api/users/1/toggle-status
```
