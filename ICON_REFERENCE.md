# Icon Reference Guide - Homepage V3

## Available Icons

When adding or editing Trust Badges, Features, or Stats in the admin panel, use these icon names:

### Trust Badge Icons
- `shield` - Shield with checkmark (security, trust)
- `clock` - Clock (time, delivery)
- `check` - Checkmark (quality, guarantee)
- `dollar` - Dollar sign (pricing, money)
- `star` - Star (premium, quality)
- `award` - Award medal (excellence)

### Feature Icons
- `box` - 3D box (product, MOQ)
- `tag` - Price tag (label, branding)
- `globe` - Globe (worldwide, global)
- `star` - Star (premium, featured)
- `check-circle` - Circle with check (verified, approved)

### Stats Icons
- `users` - Multiple users (clients, customers)
- `award` - Award medal (years, excellence)
- `clock` - Clock (delivery time)
- `check-circle` - Circle with check (quality, assurance)
- `star` - Star (rating, premium)
- `shield` - Shield (protection, guarantee)

## Usage Examples

### In Admin Panel Forms:

**Trust Badge:**
- Icon: `shield`
- Text: "Trusted by 2500+ USA Brands"

**Feature:**
- Icon: `box`
- Title: "Low MOQ"
- Subtitle: "Start with small orders"

**Stat:**
- Icon: `users`
- Number: "2500+"
- Label: "Happy Clients"

## Complete Icon List with Visual Description

| Icon Name | Description | Best Used For |
|-----------|-------------|---------------|
| `shield` | Shield with checkmark | Trust, security, protection |
| `clock` | Analog clock | Time, delivery, speed |
| `check` | Simple checkmark | Approval, quality, done |
| `dollar` | Dollar sign with lines | Pricing, cost, money |
| `box` | 3D package box | Products, MOQ, shipping |
| `tag` | Price/discount tag | Labels, branding, offers |
| `globe` | Earth globe | Worldwide, global, international |
| `star` | Five-point star | Premium, featured, favorite |
| `users` | Group of people | Clients, customers, team |
| `award` | Award medal/ribbon | Excellence, achievement, years |
| `check-circle` | Circle with checkmark | Verified, quality assurance |

## Adding Custom Icons

To add new icons, edit the `renderIcon()` function in `templates/home-v3.php` (around line 200):

```php
function renderIcon($iconName) {
    $icons = [
        'your-icon-name' => '<svg viewBox="0 0 24 24"><!-- Your SVG path here --></svg>',
        // ... existing icons
    ];
    return $icons[$iconName] ?? $icons['star'];
}
```

All icons are SVG with:
- `viewBox="0 0 24 24"`
- `fill="none"`
- `stroke="currentColor"`
- `stroke-width="2"`

This ensures consistent sizing and color inheritance (neon green).

## Tips

1. **Keep it simple:** Choose icons that clearly represent the concept
2. **Be consistent:** Use similar styles across the homepage
3. **Test visibility:** Neon green shows well on dark backgrounds
4. **Accessibility:** Icons should complement text, not replace it
