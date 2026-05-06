# Changelog

All notable changes to the PGSDT project will be documented in this file.

## [2.0.1] - 2026-05-02

### 🎨 Responsive Design Implementation

#### Complete Responsive Overhaul
- ✅ **Full responsive design** for Desktop, Tablet, and Mobile devices
- ✅ **7 breakpoints** implemented (1400px, 1200px, 992px, 768px, 600px, 400px)
- ✅ **Mobile-first navigation** with hamburger menu and full-screen overlay
- ✅ **Responsive typography** scaling across all screen sizes
- ✅ **Touch-friendly** tap targets (minimum 44x44px)
- ✅ **Optimized layouts** for all pages (Home, News, Events, Profile, Admin)

#### Navigation & Menu
- ✅ Hamburger menu for screens < 992px
- ✅ Smooth animation for menu toggle
- ✅ Full-screen mobile overlay with centered links
- ✅ Touch-friendly close button and Escape key support
- ✅ Body scroll lock when menu is open
- ✅ Brand name hides on very small screens (< 400px)

#### Hero Sections
- ✅ Responsive heights: 350px → 280px → 250px → 220px → 200px
- ✅ Scalable typography: 32px → 28px → 24px → 22px
- ✅ Vertical button stack on mobile
- ✅ Full-width buttons on small screens
- ✅ Proper background image scaling

#### News Grid
- ✅ 3 columns (desktop) → 2 columns (tablet) → 1 column (mobile)
- ✅ Responsive card images: 240px → 220px → 200px → 180px → 160px
- ✅ Adaptive padding and spacing
- ✅ Touch-friendly "Read More" links
- ✅ Responsive filter tabs and search bar

#### Event Cards
- ✅ Horizontal layout (desktop) → Vertical layout (tablet/mobile)
- ✅ Responsive map embeds
- ✅ Stacked event details on mobile
- ✅ Full-width registration buttons
- ✅ Compact padding on small screens

#### Profile & ID Card
- ✅ 2-column (desktop) → 1-column (tablet/mobile) layout
- ✅ Responsive ID card with maintained aspect ratio
- ✅ Vertical layout for card content on mobile
- ✅ Print-optimized styles (500x316px exact)
- ✅ Full-width action buttons on mobile

#### Footer
- ✅ 4-column (desktop) → 2-column (tablet) → 1-column (mobile)
- ✅ Responsive logo and social icons
- ✅ Readable contact information on all screens
- ✅ Proper spacing and alignment

#### Forms & Tables
- ✅ Input font-size: 16px (prevents iOS zoom)
- ✅ Full-width form elements on mobile
- ✅ Horizontal scroll for tables on small screens
- ✅ Touch-friendly submit buttons
- ✅ Proper validation message display

#### Performance & Accessibility
- ✅ WCAG 2.1 Level AA compliant touch targets
- ✅ Optimized animations (disabled on reduced motion)
- ✅ Lazy loading for images
- ✅ No horizontal scroll on any device
- ✅ Smooth scrolling experience

#### Documentation
- ✅ **RESPONSIVE_DESIGN.md** - Complete responsive implementation guide
- ✅ **RESPONSIVE_TESTING_GUIDE.md** - Testing checklist and procedures
- ✅ Breakpoint reference table
- ✅ Typography scaling guide
- ✅ Touch target specifications

#### Bug Fixes
- ✅ Fixed horizontal scroll issues on mobile
- ✅ Fixed iOS input zoom on focus
- ✅ Fixed navbar height consistency
- ✅ Fixed print layout for ID card
- ✅ Fixed image aspect ratios

---

## [2.0.0] - 2026-05-02

### 🎉 Major Improvements

#### Security Enhancements
- ✅ Added rate limiting for login (5 attempts/minute) and registration (3 attempts/minute)
- ✅ Enhanced NIK validation with regex pattern (16 digits numeric only)
- ✅ Improved image upload validation (size limit 2MB, dimensions check)
- ✅ Added soft delete functionality for Users, Agendas, and News
- ✅ CSRF protection on all forms

#### Email Notifications
- ✅ Automatic email to admins when new member registers
- ✅ Email notification to member when verified/approved
- ✅ Email notification for event registration status changes
- ✅ Synchronous email sending (no queue worker needed)
- ✅ Customized email templates with Balinese greetings
- ✅ Event reminder system (H-1 automatic + instant for late registration)
- ✅ Auto-confirm event registrations
- ✅ Auto-activation after email verification

#### Performance Optimization
- ✅ Implemented caching system with CacheHelper
- ✅ Auto-clear cache using Model Observers
- ✅ Optimized database queries with Eloquent scopes
- ✅ Added lazy loading for images
- ✅ Gzip compression for assets

#### SEO & PWA
- ✅ Dynamic sitemap.xml generation
- ✅ Enhanced robots.txt
- ✅ PWA manifest.json for mobile installation
- ✅ Open Graph and Twitter Card meta tags
- ✅ Improved meta descriptions

#### User Experience
- ✅ WhatsApp floating button removed (footer links only)
- ✅ Clickable WhatsApp numbers in footer
- ✅ Better error messages and validation feedback
- ✅ Loading states for forms
- ✅ Clean news and events pages (no empty space)

#### Developer Experience
- ✅ Comprehensive README.md with setup instructions
- ✅ DEPLOYMENT.md guide for production deployment
- ✅ AdminSeeder for easy admin user creation
- ✅ Model relationships and scopes
- ✅ Code organization and structure improvements

#### Configuration
- ✅ Updated locale to Indonesian (id)
- ✅ Timezone set to Asia/Makassar
- ✅ SMTP email configuration (Gmail ready)
- ✅ App name changed to "PGSDT"

### 📝 Model Enhancements

#### User Model
- Added SoftDeletes trait
- Added agendaRegistrations relationship
- Enhanced fillable and hidden attributes

#### Agenda Model
- Added SoftDeletes trait
- Added casts for dates and booleans
- Added scopes: upcoming(), featured()
- Added computed attribute: available_slots
- Added method: isFullyBooked()

#### News Model
- Added SoftDeletes trait
- Added scope: published()
- Added computed attribute: excerpt

### 🗄️ Database Changes
- Migration for soft deletes on users, agendas, and news tables

### 📧 New Notifications
- `MemberRegisteredNotification` - Sent to admins
- `MemberVerifiedNotification` - Sent to members
- `EventRegistrationNotification` - Sent to event participants

### 🔧 New Helpers
- `CacheHelper` - Centralized caching logic with auto-clear methods

### 👁️ New Observers
- `NewsObserver` - Auto-clear news cache on changes
- `AgendaObserver` - Auto-clear event cache on changes

### 📄 New Files
- `public/manifest.json` - PWA configuration
- `resources/views/sitemap.blade.php` - Dynamic sitemap
- `app/Helpers/CacheHelper.php` - Cache management
- `app/Observers/NewsObserver.php` - News cache observer
- `app/Observers/AgendaObserver.php` - Agenda cache observer
- `app/Notifications/*` - Email notification classes
- `database/seeders/AdminSeeder.php` - Admin user seeder
- `DEPLOYMENT.md` - Production deployment guide
- `CHANGELOG.md` - This file

### 🔄 Updated Files
- `.env` and `.env.example` - Updated configurations
- `config/app.php` - Timezone and locale
- `routes/web.php` - Added throttling and sitemap route
- `app/Http/Controllers/AuthController.php` - Enhanced validations and notifications
- `app/Http/Controllers/Admin/MemberController.php` - Added notifications
- `app/Http/Controllers/AgendaRegistrationController.php` - Added notifications
- `app/Providers/AppServiceProvider.php` - Registered observers
- `resources/views/layouts/app.blade.php` - PWA, SEO, WhatsApp integration
- `public/robots.txt` - Enhanced for SEO
- `README.md` - Comprehensive documentation

### 🐛 Bug Fixes
- Fixed image upload size validation (5MB → 2MB)
- Fixed NIK validation to accept only numeric values
- Improved error handling in controllers

### 🔒 Security Updates
- Rate limiting on authentication routes
- Enhanced input validation
- Secure image upload handling
- SQL injection protection via Eloquent

---

## [1.0.0] - 2026-04-30

### Initial Release
- Basic member registration and management
- News and article management
- Event/agenda management with registration
- Admin dashboard
- Email verification
- Profile management
- Heritage information page
- Responsive design with Tailwind CSS

---

## Future Roadmap

### Planned Features
- [ ] Two-factor authentication (2FA)
- [ ] Member directory with search
- [ ] Event calendar view
- [ ] Payment integration for event fees
- [ ] Member ID card generation (PDF)
- [ ] Push notifications
- [ ] Mobile app (React Native/Flutter)
- [ ] Multi-language support (Balinese/English)
- [ ] Advanced analytics dashboard
- [ ] Member forum/discussion board
- [ ] Document repository
- [ ] Photo gallery
- [ ] Video streaming for events
- [ ] Automated backup system
- [ ] API for third-party integrations

### Technical Improvements
- [ ] Automated testing (PHPUnit/Pest)
- [ ] CI/CD pipeline
- [ ] Docker containerization
- [ ] Redis caching implementation
- [ ] Image optimization with Intervention Image
- [ ] CDN integration
- [ ] Database query optimization
- [ ] API rate limiting
- [ ] Logging and monitoring (Sentry)
- [ ] Performance monitoring (New Relic/Scout)

---

**Maintained by PGSDT Development Team**

For questions or suggestions, contact: pgsdtpusat1969@gmail.com
