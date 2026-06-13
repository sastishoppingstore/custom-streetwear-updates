# Custom Streetwear Homepage V3 - Installation Guide
## Dark Neon Green 3D Streetwear Theme

### Overview
This redesign transforms customstreetwear.co into a premium dark neon green 3D streetwear manufacturer website with:
- Dark black background with neon green (#39ff14) highlights
- Fully animated and responsive design
- Glassmorphism effects
- Mobile-first approach with hamburger menu at 1100px breakpoint
- Fixed header layout with no logo/menu overlap
- Premium conversion-focused design

---

## Installation Steps

### Step 1: Run SQL Migration

Execute the SQL migration to create homepage content tables:

```bash
mysql -u your_username -p your_database < customstreetwear.co/migration-homepage-v3.sql
```

Or via phpMyAdmin:
1. Open phpMyAdmin
2. Select your database
3. Click "Import"
4. Upload `migration-homepage-v3.sql`
5. Click "Go"

This creates the following tables:
- `homepage_hero` - Hero section content
- `homepage_topbar` - Top contact bar settings
- `homepage_trust_badges` - Trust bar badges
- `homepage_features` - Feature cards
- `homepage_categories` - Product category cards
- `homepage_stats` - Statistics section

### Step 2: Verify Files Are in Place

All files should already be created. Verify these exist:

**Templates:**
- `customstreetwear.co/templates/home-v3.php`

**CSS:**
- `customstreetwear.co/assets/css/home-v3.css`

**JavaScript:**
- `customstreetwear.co/assets/js/home-v3-animations.js`

**Admin Panel:**
- `customstreetwear.co/admin/homepage-v3.php`

**Updated Files:**
- `customstreetwear.co/includes/header.php` (updated)
- `customstreetwear.co/index.php` (updated to route to home-v3.php)

### Step 3: Upload Images

Create and upload the following images:

**Hero Section:**
- `/uploads/hero/3d-hoodie.png` - Main 3D hoodie/streetwear model (recommended: 500x600px)
- `/uploads/hero/dark-factory-bg.jpg` - Background image (optional)

**Category Cards (recommended: 400x480px each):**
- `/uploads/categories/hoodies.jpg`
- `/uploads/categories/tracksuits.jpg`
- `/uploads/categories/tshirts.jpg`
- `/uploads/categories/jackets.jpg`
- `/uploads/categories/shorts.jpg`
- `/uploads/categories/accessories.jpg`

**Logo:**
- `/uploads/settings/logo.png` - Main logo (recommended: height 50px, transparent background)

### Step 4: Configure Admin Panel

1. Access admin panel: `https://yourdomain.com/admin/homepage-v3.php`
2. Login with admin credentials
3. Configure each section:

#### Hero Section Tab:
- Label Text: "MANUFACTURER & EXPORTER SINCE 2012"
- Main Heading: "PREMIUM CUSTOM STREETWEAR"
- Subheading: Your company description
- Primary Button: "EXPLORE CUSTOMISATIONS" → /customisations
- Secondary Button: "VIEW COLLECTION" → /category/all
- Hero Image: Path to 3D model image
- Background Image: Path to background image

#### Top Bar Tab:
- Phone: +92 331 0000000
- Email: info@customstreetwear.co
- Address: Bajwa Street Rangpura, Sialkot - 51310, Pakistan
- Show Social Icons: ☑
- Show Cart Icon: ☐ (optional)

#### Trust Badges Tab:
Default badges are pre-populated. Edit or add more:
- Trusted by 2500+ USA Brands
- Ships Within 15–20 Days
- 100% Quality Guaranteed
- Factory-Direct Pricing

#### Features Tab:
Default features are pre-populated:
- Low MOQ
- Private Label
- Global Shipping
- Premium Quality

#### Categories Tab:
Update with your actual product categories and images

#### Stats Tab:
Update with your actual statistics:
- 2500+ Happy Clients
- 12+ Years of Excellence
- 15–20 Days On-Time Delivery
- 100% Quality Assurance

### Step 5: Configure Settings

Update these settings in the main Settings page:

**Contact Information:**
- WhatsApp Number: For floating WhatsApp button
- Social Media Links: Facebook, Instagram URLs
- Site Phone, Email, Address

**SEO Settings:**
- Home Meta Title: "Custom Streetwear Manufacturer | Private Label Apparel Factory"
- Home Meta Description: "Custom Streetwear is a premium apparel manufacturer in Sialkot, Pakistan, offering custom hoodies, tracksuits, jackets, uniforms, private label clothing and worldwide shipping."

---

## Design Features

### Color Scheme
- **Primary Green:** #39ff14 (Neon Green)
- **Background:** #0a0a0a (Dark Black)
- **Card Background:** #111111 (Dark Gray)
- **Borders:** #1a1a1a (Darker Gray)
- **Text:** #ffffff (White) / #cccccc (Light Gray)

### Typography
- **Headings:** Oswald (Bold, Uppercase)
- **Body:** Inter (Clean, Modern)

### Responsive Breakpoints
- **Desktop:** 1101px+ (Full navigation)
- **Tablet:** 769px - 1100px (Hamburger menu)
- **Mobile:** ≤768px (Mobile optimized)

### Animations
- Hero particles (50 floating particles)
- Fade-up scroll animations
- Parallax hero image
- Counter animations for stats
- Hover glow effects on cards
- Smooth transitions throughout

### Header Behavior
- **Desktop (≥1100px):**
  - Top contact bar with phone, email, address, social icons
  - Logo on left (max 200px)
  - Centered navigation menu
  - "Request a Quote" button on right
  - No overlap guaranteed

- **Mobile (<1100px):**
  - Logo on left
  - Hamburger icon on right
  - Quote button (icon only)
  - Full-screen slide-in drawer menu
  - All menu items accessible

### Mobile Menu
- Slides in from right
- Dark overlay backdrop
- Smooth animations
- Close button
- All navigation items
- Quote button inside drawer
- Contact information at bottom

---

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile Safari (iOS 14+)
- Chrome Mobile (Android 10+)

---

## Performance Optimization

- Lazy loading on category images
- Image dimensions specified for faster rendering
- CSS and JS versioned with file modification time
- Minimal JavaScript (vanilla JS, no frameworks)
- Optimized animations with requestAnimationFrame
- Efficient CSS with minimal reflows

---

## Testing Checklist

### Desktop Testing (1920x1080)
- [ ] Logo visible and properly sized
- [ ] All menu items visible
- [ ] No overlap between logo and menu
- [ ] Request Quote button visible on right
- [ ] Hero section displays correctly
- [ ] Trust bar 4 columns
- [ ] Features 4 columns
- [ ] Categories 3 columns
- [ ] Stats 4 columns
- [ ] All animations working

### Tablet Testing (768px - 1100px)
- [ ] Hamburger menu appears at 1100px
- [ ] Mobile drawer opens/closes smoothly
- [ ] Trust bar 2 columns
- [ ] Features 2 columns
- [ ] Categories 2 columns
- [ ] Stats 2 columns

### Mobile Testing (375px)
- [ ] Logo readable
- [ ] Hamburger menu accessible
- [ ] Drawer menu slides in properly
- [ ] All content readable
- [ ] Trust badges stack vertically
- [ ] Features 1 column
- [ ] Categories 2 columns
- [ ] Stats 1 column
- [ ] WhatsApp button doesn't cover content
- [ ] Buttons are tappable (min 44x44px)

### Zoom Testing
- [ ] 80% zoom - no overlap
- [ ] 100% zoom - no overlap
- [ ] 125% zoom - no overlap
- [ ] 150% zoom - hamburger menu appears if needed

---

## Troubleshooting

### Issue: Images not displaying
**Solution:** Check file paths and ensure images are uploaded to correct directories

### Issue: Animations not working
**Solution:** Clear browser cache, verify home-v3-animations.js is loading

### Issue: Menu overlapping on certain screen sizes
**Solution:** The breakpoint is set at 1100px. Adjust in CSS if needed:
```css
@media (max-width: 1100px) {
    .desktop-nav { display: none !important; }
    .mobile-hamburger { display: flex !important; }
}
```

### Issue: Database tables not created
**Solution:** Check MySQL user permissions and run migration manually

### Issue: Mobile menu not opening
**Solution:** Check browser console for JS errors, ensure toggleMobileMenu() function exists

---

## Customization

### Change Neon Green Color
Edit `home-v3.css` line 8:
```css
--color-neon-green: #39ff14; /* Change to your color */
```

### Adjust Animation Speed
Edit `home-v3.css` lines 15-17:
```css
--transition-fast: 0.2s ease;
--transition-normal: 0.3s ease;
--transition-slow: 0.5s ease;
```

### Change Hamburger Breakpoint
Edit `home-v3.css` around line 1160:
```css
@media (max-width: 1100px) { /* Change 1100px to your preference */
```

### Modify Particle Count
Edit `home-v3-animations.js` line 74:
```javascript
const particleCount = 50; // Increase or decrease
```

---

## Support & Maintenance

### Regular Updates
- Keep images optimized (use WebP format when possible)
- Update content through admin panel regularly
- Monitor page load speed
- Test on new browser versions

### Content Updates
All homepage content is editable through:
`/admin/homepage-v3.php`

No code changes needed for:
- Hero text and images
- Trust badges
- Feature cards
- Product categories
- Statistics
- Contact information

---

## Security Notes

- Admin panel requires authentication
- CSRF tokens implemented on all forms
- SQL injection protection via prepared statements
- XSS protection via htmlspecialchars()
- All user inputs sanitized

---

## Performance Metrics Goals

- First Contentful Paint: <2s
- Largest Contentful Paint: <3s
- Time to Interactive: <4s
- Cumulative Layout Shift: <0.1

---

## Credits

**Design:** Premium Dark Neon Green 3D Streetwear Theme
**Framework:** Core PHP, MySQL, Vanilla JavaScript
**CSS:** Custom responsive grid with glassmorphism
**Fonts:** Inter (body), Oswald (headings)

---

## Version History

**Version 3.0.0** - June 2026
- Initial dark neon green redesign
- Full responsive implementation
- Fixed header layout issues
- Mobile-first approach
- Premium animations
- Conversion-focused design

---

For technical support or customization requests, please contact your development team.
