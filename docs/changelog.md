# Changelog - RideNow

All notable changes to the RideNow project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.0] - 2025-09-25

### Added

-   **Help System**: Complete help system with 3 pages (Help, Terms & Conditions, Privacy Policy)
-   **Full-screen Layout**: New `fullpage.blade.php` layout for public pages
-   **Console Commands**: `php artisan setup:rental-data` command for complete system setup
-   **Gmail-based Renters**: Realistic Gmail-based renter accounts for authentic rental history
-   **Enhanced Pagination**: Custom advanced pagination component with progress bars
-   **Revenue Sharing Fix**: Fixed revenue sharing calculations and display issues
-   **Dashboard Analytics**: Improved analytics cards with gradient designs

### Enhanced

-   **Owner Dashboard**: Fixed dynamic data loading issues, now shows real metrics
-   **Database Seeders**: Added multiple specialized seeders (GmailRenterSeeder, GmailRentalSeeder, etc.)
-   **Documentation**: Updated all documentation files with latest changes
-   **Code Quality**: Fixed PHP Intelephense errors and improved code consistency

### Fixed

-   **Dashboard Data**: Fixed owner dashboard showing 0 values for all metrics
-   **Authentication**: Resolved undefined method 'user' errors in controllers
-   **File Cleanup**: Removed unnecessary files and folders from project
-   **Login Page**: Removed forgot password functionality as requested
-   **Admin Settings**: Fixed corrupted HTML and styling consistency issues

### Removed

-   **Social Media Icons**: Removed from footer as requested
-   **Forgot Password**: Removed link from login page
-   **Unnecessary Files**: Cleaned up .vscode, documentation reports, compiled views
-   **Section 9**: Removed from Terms & Conditions page

### Security

-   **Phone Numbers**: Updated all phone numbers to client-specified number (085189094514)
-   **Contact Info**: Centralized contact information management

## [1.1.0] - 2025-09-23

### Added

-   **Multi-role Authentication**: Admin, Owner, Renter roles with proper permissions
-   **Motor Verification**: Admin verification workflow for motor listings
-   **Revenue Sharing**: Automated revenue calculation between platform and owners
-   **Payment Integration**: Payment processing with multiple methods
-   **Booking System**: Complete booking lifecycle management
-   **Analytics Dashboard**: Role-specific dashboard analytics

### Enhanced

-   **Database Schema**: Optimized with proper relationships and indexes
-   **UI/UX**: Responsive design with Tailwind CSS
-   **Security**: CSRF protection, input validation, authorization middleware

## [1.0.0] - 2025-09-22

### Added

-   **Initial Release**: Basic rental motor system
-   **User Management**: User registration and authentication
-   **Motor Listings**: Basic motor CRUD operations
-   **Basic Booking**: Simple booking functionality
-   **Database Structure**: Initial database migrations and seeders

---

## Legend

-   **Added**: New features
-   **Enhanced**: Improvements to existing features
-   **Fixed**: Bug fixes
-   **Removed**: Removed features
-   **Security**: Security-related changes
-   **Deprecated**: Features that will be removed in future versions

---

**Maintained by**: RideNow Development Team  
**Last Updated**: September 25, 2025
