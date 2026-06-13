<?php
/**
 * Long Description Generator
 * Generates 2000+ word full_description for all products and categories
 * Run once via browser: yourdomain.com/admin/generate-descriptions.php
 */

// Security: simple token check
$secret = 'csw_gen_2025';
if (($_GET['key'] ?? '') !== $secret) {
    die('<b>Access denied.</b> Add ?key=csw_gen_2025 to URL');
}

define('CSW_ROOT', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';

$dryRun  = isset($_GET['dry']);
$type    = $_GET['type'] ?? 'both'; // products | categories | both
$force   = isset($_GET['force']);   // overwrite existing

// ─── DESCRIPTION GENERATOR ───────────────────────────────────────────────────

function generateProductDescription(string $name, string $slug, string $categoryName, string $shortDesc = ''): string
{
    $n  = htmlspecialchars($name);
    $cn = htmlspecialchars($categoryName);
    $sd = $shortDesc ? htmlspecialchars($shortDesc) : "high-quality custom $n";

    return <<<HTML
<h2>Custom $n — Premium Quality Manufacturer USA</h2>
<p>Welcome to Custom Streetwear's dedicated page for <strong>custom $n</strong>. As one of the leading <strong>custom apparel manufacturers in the USA</strong>, we specialize in producing premium-grade $n for brands, teams, businesses, schools, and organizations across the United States. Whether you need small-batch custom orders or large-scale bulk production, our state-of-the-art manufacturing facility is equipped to deliver excellence at every step.</p>

<p>$sd. At Custom Streetwear, we understand that your brand identity depends on consistent quality, precise craftsmanship, and on-time delivery — and that is exactly what we deliver with every order of custom $n.</p>

<h2>Why Choose Our Custom $n?</h2>
<p>Choosing the right manufacturer for your <strong>custom $n</strong> is a critical decision for any brand or business. At Custom Streetwear, we combine decades of garment manufacturing expertise with cutting-edge technology to produce $n that truly stand out in the market. Here is why thousands of brands across the USA trust us as their preferred <strong>$n manufacturer</strong>:</p>

<ul>
<li><strong>Premium Fabrics:</strong> We source only the finest materials — GSM-certified cotton, polyester blends, fleece, French terry, and performance fabrics — to ensure every $n meets and exceeds quality expectations.</li>
<li><strong>Full Customization:</strong> From custom colors and cuts to embroidery, screen printing, sublimation, heat transfer, and private labeling — we offer end-to-end customization tailored to your exact specifications.</li>
<li><strong>Factory-Direct Pricing:</strong> Because we are the manufacturer, not a middleman, you receive competitive wholesale pricing that maximizes your profit margins without compromising on quality.</li>
<li><strong>Fast Turnaround:</strong> Our streamlined production process allows us to complete most orders within 15–20 business days, ensuring you never miss a market opportunity or seasonal deadline.</li>
<li><strong>Quality Control:</strong> Every $n goes through a rigorous 12-point quality inspection before packaging and shipping, guaranteeing that every unit you receive is perfect.</li>
<li><strong>Worldwide Shipping:</strong> We ship to all 50 U.S. states and internationally, with real-time tracking so you always know where your order is.</li>
<li><strong>No Minimum Order Quantity Pressure:</strong> Whether you need 50 pieces for a startup or 50,000 for a national campaign, we accommodate orders of every size.</li>
</ul>

<h2>Our Custom $n Production Process</h2>
<p>When you partner with Custom Streetwear for your <strong>custom $n</strong> needs, you gain access to a transparent, collaborative, and highly professional production process designed to bring your vision to life with precision and care.</p>

<h3>Step 1 — Consultation &amp; Design Brief</h3>
<p>Our process begins with a thorough consultation where our expert team works with you to understand your brand requirements, design ideas, target audience, and delivery timeline. We review your artwork, logo files, color references (Pantone or hex codes), size charts, and any special customization requirements. This ensures that we start production with a crystal-clear understanding of your expectations.</p>

<h3>Step 2 — Tech Pack &amp; Sampling</h3>
<p>Once the design brief is finalized, our technical team creates a detailed tech pack for your custom $n. This includes fabric specifications, construction details, stitching guidelines, measurement charts, and finishing notes. We then produce a pre-production sample for your approval. You can request modifications at this stage at no extra cost, ensuring the final product is exactly what you envisioned.</p>

<h3>Step 3 — Bulk Production</h3>
<p>After sample approval, we move into full-scale bulk production of your custom $n. Our factory is equipped with modern sewing lines, cutting machines, embroidery units, and printing stations capable of handling high-volume orders while maintaining consistent quality across every unit. Our experienced production team follows your approved sample as the benchmark throughout the entire run.</p>

<h3>Step 4 — Quality Inspection</h3>
<p>Before any $n leaves our facility, it undergoes a comprehensive quality control inspection. Our QC team checks stitching strength, color accuracy, measurement compliance, print/embroidery quality, fabric integrity, and overall finishing. Only items that pass all quality checkpoints proceed to packaging.</p>

<h3>Step 5 — Packaging &amp; Shipping</h3>
<p>We offer custom packaging options including polybags, hang tags, custom labels, and branded boxes. Your order is then carefully packed and shipped via trusted logistics partners with real-time tracking. We provide full shipping documentation and assist with any customs requirements for international orders.</p>

<h2>Custom $n for Every Industry</h2>
<p>Our <strong>custom $n manufacturing</strong> services cater to a wide range of industries and use cases. Here are some of the most common applications:</p>

<ul>
<li><strong>Sports Teams &amp; Athletics:</strong> Custom $n designed for performance, durability, and team identity. We work with professional leagues, amateur sports clubs, school athletic departments, and fitness brands.</li>
<li><strong>Corporate &amp; Workwear:</strong> Professional-grade custom $n with company logos, brand colors, and employee sizing. Perfect for uniforms, promotional events, and corporate gifting.</li>
<li><strong>Fashion Brands &amp; Streetwear Labels:</strong> We are the manufacturing backbone for dozens of emerging and established streetwear brands. Our expertise in trend-forward designs and premium construction makes us the go-to partner for fashion entrepreneurs.</li>
<li><strong>Promotional &amp; Marketing:</strong> Custom $n as branded merchandise for product launches, trade shows, influencer campaigns, and customer loyalty programs.</li>
<li><strong>Schools &amp; Universities:</strong> Student organizations, varsity teams, and school spirit programs rely on our custom $n for consistent quality and affordable bulk pricing.</li>
<li><strong>E-commerce &amp; Print-on-Demand:</strong> We support online sellers and dropshipping businesses with flexible production runs and discreet private-label packaging.</li>
</ul>

<h2>Fabric &amp; Material Options for Custom $n</h2>
<p>The right fabric is the foundation of any great $n. At Custom Streetwear, we offer an extensive selection of high-quality materials to match your performance, comfort, and aesthetic requirements:</p>

<ul>
<li><strong>100% Cotton:</strong> Soft, breathable, and hypoallergenic — ideal for casual and lifestyle $cn products.</li>
<li><strong>Cotton-Polyester Blend:</strong> Combines the comfort of cotton with the durability and shape retention of polyester. One of the most popular choices for custom $n.</li>
<li><strong>French Terry:</strong> A premium mid-weight knit fabric that offers a smooth outer surface and a looped inner — perfect for comfort-focused $n.</li>
<li><strong>Fleece:</strong> Soft, warm, and cozy — fleece is the go-to fabric for cold-weather custom $n with exceptional insulation properties.</li>
<li><strong>Performance / Moisture-Wicking:</strong> Engineered fabrics designed to pull sweat away from the skin, ideal for athletic and activewear $n.</li>
<li><strong>Sublimation-Ready Polyester:</strong> For all-over print custom $n with vivid, photo-realistic designs that never fade or crack.</li>
<li><strong>Organic &amp; Recycled Fabrics:</strong> Sustainable fabric options for eco-conscious brands committed to reducing environmental impact.</li>
</ul>

<h2>Customization Techniques for $n</h2>
<p>We offer industry-leading customization techniques to make your <strong>custom $n</strong> truly one of a kind:</p>

<ul>
<li><strong>Embroidery:</strong> Thread-based designs with a premium, professional look. Ideal for logos, monograms, and brand marks. Flat embroidery, 3D puff embroidery, and chain stitch available.</li>
<li><strong>Screen Printing:</strong> High-opacity, vibrant ink prints perfect for bold graphic designs and multi-color artwork. Available in water-based, plastisol, and discharge inks.</li>
<li><strong>Sublimation Printing:</strong> All-over, full-color printing that becomes part of the fabric itself. No cracking, no peeling — ever.</li>
<li><strong>Heat Transfer &amp; DTF:</strong> Direct-to-Film and heat transfer printing for detailed, photographic designs with excellent color accuracy.</li>
<li><strong>Woven &amp; Printed Labels:</strong> Custom neck labels, size labels, care labels, and brand tags to complete the premium branded experience.</li>
<li><strong>Patches:</strong> Embroidered, woven, PVC, or chenille patches for authentic streetwear and varsity aesthetics.</li>
<li><strong>Custom Hardware:</strong> Metal zippers, custom drawstrings, branded buttons, and specialty hardware to elevate the premium feel of your $n.</li>
</ul>

<h2>Sizing &amp; Fit Options</h2>
<p>We manufacture custom $n in a comprehensive range of sizes and fits to serve diverse markets and demographics:</p>
<ul>
<li>XS, S, M, L, XL, 2XL, 3XL, 4XL, 5XL standard sizing</li>
<li>Youth and kids sizing (XS–XL youth)</li>
<li>Unisex, men's, and women's specific fits</li>
<li>Oversized and boxy fits for streetwear aesthetics</li>
<li>Slim fit and athletic/tapered fits for sports and activewear</li>
<li>Custom graded size sets based on your brand's fit specifications</li>
</ul>

<h2>Pricing &amp; Minimum Order Quantities</h2>
<p>At Custom Streetwear, we believe premium quality custom $n should be accessible to businesses of all sizes. Our pricing structure is transparent and competitive:</p>
<ul>
<li><strong>Sample Orders:</strong> Single samples available for quality and fit evaluation before bulk production commitment.</li>
<li><strong>Small Batch:</strong> Starting from as few as 50 pieces per design for most $n styles.</li>
<li><strong>Bulk Discounts:</strong> Significant per-unit price reductions for orders of 200, 500, 1000+ pieces.</li>
<li><strong>Factory-Direct:</strong> No import markups or middleman margins — you pay manufacturer prices directly.</li>
</ul>
<p>Request a custom quote today to receive detailed pricing based on your specific requirements, quantity, and customization needs.</p>

<h2>Frequently Asked Questions — Custom $n</h2>

<h3>How long does it take to produce custom $n?</h3>
<p>Standard production time for custom $n is 15–20 business days from sample approval. Rush production options are available for time-sensitive orders at an additional cost. We always communicate proactively about timelines and any potential delays.</p>

<h3>Do you provide samples before bulk production?</h3>
<p>Yes. We strongly recommend ordering a pre-production sample before committing to bulk manufacturing. Samples allow you to verify fit, fabric quality, print accuracy, and overall construction before the full order is produced.</p>

<h3>What file formats do you accept for artwork?</h3>
<p>We accept vector files (AI, EPS, PDF) for the best print and embroidery quality. High-resolution raster files (300 DPI PNG, TIFF, PSD) are also accepted for certain techniques. Our design team can assist with artwork preparation and vectorization if needed.</p>

<h3>Can I order custom $n with my own private label?</h3>
<p>Absolutely. We specialize in private-label custom $n manufacturing. We can remove all our branding and add your custom woven labels, hang tags, and branded packaging to create a fully white-label product line under your brand identity.</p>

<h3>What is your return and quality guarantee policy?</h3>
<p>We stand behind the quality of every $n we produce. If any items do not meet the approved sample standards, we will remanufacture or replace them at no cost. Our goal is 100% customer satisfaction on every order.</p>

<h3>Do you ship custom $n internationally?</h3>
<p>Yes. While our primary market is the USA, we ship to Canada, the UK, Australia, Europe, and globally. We handle all shipping documentation and can advise on import regulations and duties for your destination country.</p>

<h2>Start Your Custom $n Order Today</h2>
<p>Ready to elevate your brand with premium <strong>custom $n</strong>? The Custom Streetwear team is standing by to help you create the perfect $n that represents your brand, meets your quality standards, and delivers on time, every time.</p>

<p>Contact us today to request a free quote, discuss your design requirements, or order a sample. Join the thousands of satisfied brands, teams, and businesses across the USA who trust Custom Streetwear as their <strong>custom $cn manufacturer of choice</strong>.</p>

<p><strong>Custom Streetwear — Crafted with Precision. Worn with Purpose.</strong></p>
HTML;
}

function generateCategoryDescription(string $name, string $slug, string $existingDesc = ''): string
{
    $n  = htmlspecialchars($name);
    $ed = $existingDesc ? htmlspecialchars($existingDesc) : "We offer a comprehensive range of custom $n.";

    return <<<HTML
<h2>Custom $n Manufacturer USA — Premium Quality Factory-Direct</h2>
<p>Welcome to Custom Streetwear's complete <strong>custom $n</strong> collection. As a leading USA-focused <strong>custom apparel manufacturer</strong> based in Sialkot — the sportswear capital of the world — we produce premium-grade custom $n for brands, sports teams, corporate clients, schools, and businesses of all sizes across the United States and worldwide.</p>

<p>$ed. Our custom $n collection represents the best combination of quality craftsmanship, innovative design, and affordable factory-direct pricing available in today's market.</p>

<h2>About Our Custom $n Collection</h2>
<p>The Custom Streetwear <strong>$n category</strong> encompasses a wide range of styles, cuts, fabrics, and customization options. Whether you are a startup fashion brand looking for your first private-label production run, an established athletic organization needing bulk team uniforms, or a corporate business seeking branded workwear — our custom $n collection has everything you need.</p>

<p>Every product in our <strong>custom $n</strong> lineup is manufactured using premium materials sourced from certified suppliers. Our skilled artisans and modern production technology ensure that every piece meets rigorous quality standards before it reaches your hands.</p>

<h2>Why Custom Streetwear is the Best $n Manufacturer for USA Brands</h2>
<p>With hundreds of apparel manufacturers competing for your business, choosing the right partner is critical. Here is what sets Custom Streetwear apart as the premier <strong>custom $n manufacturer</strong> for U.S.-based brands and businesses:</p>

<ul>
<li><strong>Decades of Manufacturing Expertise:</strong> Our team brings extensive experience in garment construction, fabric technology, and custom production to every $n order.</li>
<li><strong>Vertically Integrated Production:</strong> From fabric cutting and sewing to printing, embroidery, and packaging — everything happens under one roof, ensuring quality control at every step.</li>
<li><strong>Dedicated Account Management:</strong> Every client receives a dedicated account manager who oversees your order from initial consultation through final delivery.</li>
<li><strong>Transparent Communication:</strong> We provide regular production updates, photo documentation, and proactive communication so you are never left wondering about your order status.</li>
<li><strong>Competitive Lead Times:</strong> Our efficient production systems allow us to deliver most custom $n orders within 15–20 business days of sample approval.</li>
<li><strong>Sustainable Practices:</strong> We offer eco-friendly fabric options and are committed to responsible manufacturing practices that minimize environmental impact.</li>
<li><strong>USA Market Expertise:</strong> We understand U.S. sizing standards, trend preferences, seasonal demands, and compliance requirements, making us the ideal manufacturing partner for American brands.</li>
</ul>

<h2>Popular Products in Our Custom $n Collection</h2>
<p>Our <strong>custom $n</strong> collection includes a diverse range of products designed to meet every brand and business need. Browse our extensive catalog to find the perfect $n products for your specific requirements. Each product can be fully customized with your brand's colors, logos, graphics, and finishing details.</p>

<p>Whether you are looking for performance-grade athletic $n, fashion-forward streetwear pieces, professional corporate $n, or specialized workwear and safety apparel — our collection has you covered. Our design team can also work with you to create completely custom styles from scratch if you have a unique vision that goes beyond our existing catalog.</p>

<h2>Customization Options Available for All $n Products</h2>
<p>Every product in our custom $n collection can be personalized to reflect your unique brand identity. Our comprehensive customization capabilities include:</p>

<ul>
<li><strong>Custom Colors &amp; Colorways:</strong> Pantone-matched fabric dyeing and printing to achieve your exact brand colors across the entire $n collection.</li>
<li><strong>Logo &amp; Graphic Application:</strong> Embroidery, screen printing, sublimation, heat transfer, DTF printing, and woven patch application for all branding needs.</li>
<li><strong>Custom Cuts &amp; Silhouettes:</strong> Modify existing patterns or develop entirely new silhouettes through our cut-and-sew custom manufacturing service.</li>
<li><strong>Private Label Branding:</strong> Custom woven neck labels, size labels, care labels, hang tags, and branded packaging to create a fully white-label product line.</li>
<li><strong>Hardware &amp; Trims:</strong> Custom zippers, drawstrings, buttons, snaps, grommets, and specialty hardware to add unique design details to your $n.</li>
<li><strong>Specialty Finishes:</strong> Stone wash, enzyme wash, acid wash, garment dye, and other treatment options for unique aesthetic effects.</li>
</ul>

<h2>Industries We Serve with Custom $n</h2>
<p>Our custom $n manufacturing expertise spans across multiple industries:</p>

<ul>
<li><strong>Sports &amp; Athletics:</strong> Professional and amateur sports teams, athletic clubs, fitness studios, martial arts schools, and sports brands.</li>
<li><strong>Fashion &amp; Streetwear:</strong> Independent designers, emerging brands, established labels, and fashion entrepreneurs building their own clothing lines.</li>
<li><strong>Corporate &amp; Business:</strong> Companies seeking branded uniforms, promotional merchandise, and employee workwear in the $n category.</li>
<li><strong>Education:</strong> Universities, colleges, schools, and student organizations needing custom $n for teams, events, and campus merchandise.</li>
<li><strong>Healthcare &amp; Safety:</strong> Hospitals, clinics, construction companies, and industrial businesses requiring specialized $n with safety and compliance features.</li>
<li><strong>Promotional &amp; Events:</strong> Marketing agencies, event planners, and businesses creating branded $n for campaigns, trade shows, and merchandise programs.</li>
<li><strong>E-commerce &amp; Retail:</strong> Online retailers, dropshipping entrepreneurs, and brick-and-mortar stores building private-label $n product lines.</li>
</ul>

<h2>Quality Standards &amp; Certifications</h2>
<p>Quality is not just a promise at Custom Streetwear — it is a systematic process built into every stage of our custom $n production. Our quality management practices include:</p>

<ul>
<li>Pre-production fabric testing for GSM, shrinkage, colorfastness, and tensile strength</li>
<li>In-process quality checks at cutting, sewing, and assembly stages</li>
<li>Final inspection against approved sample standards before packaging</li>
<li>Random sampling from bulk orders for additional quality verification</li>
<li>Comprehensive documentation of quality control checkpoints for full traceability</li>
</ul>

<h2>How to Order Custom $n</h2>
<p>Getting started with your custom $n order is simple and straightforward:</p>

<ol>
<li><strong>Browse &amp; Select:</strong> Explore our $n collection and identify the products that best match your requirements.</li>
<li><strong>Request a Quote:</strong> Submit your requirements through our quote request form or contact us directly via email or WhatsApp. Include your desired quantity, customization details, and timeline.</li>
<li><strong>Design Review:</strong> Share your artwork, logos, and design files with our team. We will review and provide feedback or suggestions to optimize your designs for production.</li>
<li><strong>Sample Approval:</strong> We produce a pre-production sample for your review and approval. This ensures the final bulk order meets your exact specifications.</li>
<li><strong>Bulk Production:</strong> Upon sample approval and order confirmation, we begin bulk production with regular progress updates.</li>
<li><strong>Quality Control &amp; Shipping:</strong> Final QC inspection followed by packaging and shipping with real-time tracking to your USA address.</li>
</ol>

<h2>Frequently Asked Questions — Custom $n Collection</h2>

<h3>What is the minimum order quantity for custom $n?</h3>
<p>Minimum order quantities vary by product type within our $n collection. Most products have a minimum of 50 pieces per style and color. Contact us for specific MOQs for the exact products you are interested in.</p>

<h3>How long does custom $n production take?</h3>
<p>Standard lead time is 15–20 business days from sample approval. Rush production is available for urgent orders. We recommend planning 4–6 weeks from initial inquiry to delivery for first-time orders to allow time for sampling and revisions.</p>

<h3>Can I get custom $n with no minimum order?</h3>
<p>We offer sample ordering for single pieces or very small quantities for evaluation purposes. For commercial custom $n production, minimum quantities apply to ensure cost-effective manufacturing. We can discuss flexible arrangements for established clients.</p>

<h3>Do you offer private label custom $n?</h3>
<p>Yes. Private label manufacturing is one of our core specializations. We can produce your entire $n line under your brand with custom labels, hang tags, and packaging — with zero Custom Streetwear branding visible anywhere on the product.</p>

<h3>What payment terms do you offer for custom $n orders?</h3>
<p>We typically require a 50% deposit to initiate production with the remaining 50% due before shipment. For established clients with a track record, extended payment terms may be available. We accept wire transfer, PayPal, and other secure payment methods.</p>

<h2>Get Started with Custom $n Today</h2>
<p>Do not let subpar manufacturing hold your brand back. Partner with Custom Streetwear — the USA's trusted <strong>custom $n manufacturer</strong> — and experience the difference that true craftsmanship, premium materials, and dedicated service can make for your business.</p>

<p>Browse our complete <strong>custom $n collection</strong> above, or <a href="/contact">contact our team today</a> to request a free quote and start your order. We look forward to bringing your vision to life.</p>

<p><strong>Custom Streetwear — Premium Custom $n Manufactured with Precision for USA Brands.</strong></p>
HTML;
}

// ─── MAIN PROCESSING ─────────────────────────────────────────────────────────

$results = [];
$errors  = [];

// Products
if (in_array($type, ['products', 'both'])) {
    $products = dbFetchAll("SELECT id, title, slug, short_description, full_description, category_id FROM products WHERE status = 1 ORDER BY id");
    $catMap   = [];
    $cats     = dbFetchAll("SELECT id, name FROM categories");
    foreach ($cats as $c) $catMap[$c['id']] = $c['name'];

    foreach ($products as $p) {
        if (!$force && !empty($p['full_description']) && strlen($p['full_description']) > 500) {
            $results[] = "SKIP product [{$p['id']}] {$p['title']} (already has description, use ?force to overwrite)";
            continue;
        }
        $catName = $catMap[$p['category_id']] ?? 'Custom Apparel';
        $desc    = generateProductDescription($p['title'], $p['slug'], $catName, $p['short_description'] ?? '');

        if (!$dryRun) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE products SET full_description = ? WHERE id = ?");
            $stmt->execute([$desc, $p['id']]);
        }
        $wordCount = str_word_count(strip_tags($desc));
        $results[] = "✅ product [{$p['id']}] {$p['title']} — {$wordCount} words" . ($dryRun ? ' (DRY RUN)' : '');
    }
}

// Categories
if (in_array($type, ['categories', 'both'])) {
    $categories = dbFetchAll("SELECT id, name, slug, description FROM categories WHERE status = 1 ORDER BY id");

    foreach ($categories as $c) {
        if (!$force && !empty($c['description']) && strlen($c['description']) > 500) {
            $results[] = "SKIP category [{$c['id']}] {$c['name']} (already has description, use ?force to overwrite)";
            continue;
        }
        $desc = generateCategoryDescription($c['name'], $c['slug'], $c['description'] ?? '');

        if (!$dryRun) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE categories SET description = ? WHERE id = ?");
            $stmt->execute([$desc, $c['id']]);
        }
        $wordCount = str_word_count(strip_tags($desc));
        $results[] = "✅ category [{$c['id']}] {$c['name']} — {$wordCount} words" . ($dryRun ? ' (DRY RUN)' : '');
    }
}

// ─── OUTPUT ──────────────────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html>
<head>
<title>Description Generator</title>
<style>
body { font-family: monospace; background: #111; color: #eee; padding: 24px; }
h1   { color: #0f0; }
.ok  { color: #4f4; }
.skip{ color: #fa0; }
.err { color: #f44; }
.box { background: #1a1a1a; border: 1px solid #333; padding: 16px; border-radius: 8px; margin: 16px 0; }
a    { color: #4af; }
</style>
</head>
<body>
<h1>🔧 Description Generator</h1>
<div class="box">
<b>Mode:</b> <?= $dryRun ? '🟡 DRY RUN (no DB changes)' : '🟢 LIVE (writing to DB)' ?><br>
<b>Type:</b> <?= htmlspecialchars($type) ?><br>
<b>Force overwrite:</b> <?= $force ? 'Yes' : 'No' ?><br><br>
<b>Options:</b><br>
• <a href="?key=csw_gen_2025&dry">Dry run (preview only)</a><br>
• <a href="?key=csw_gen_2025">Run on products + categories (skip existing)</a><br>
• <a href="?key=csw_gen_2025&force">Force overwrite ALL descriptions</a><br>
• <a href="?key=csw_gen_2025&type=products">Products only</a><br>
• <a href="?key=csw_gen_2025&type=categories">Categories only</a>
</div>

<h2>Results (<?= count($results) ?> processed)</h2>
<?php foreach ($results as $r): ?>
<div class="<?= str_starts_with($r, '✅') ? 'ok' : (str_starts_with($r, 'SKIP') ? 'skip' : 'err') ?>"><?= htmlspecialchars($r) ?></div>
<?php endforeach; ?>

<?php if (!$dryRun && count($results) > 0): ?>
<div class="box ok">✅ Done! All descriptions updated in database.</div>
<?php endif; ?>

<p style="color:#666;margin-top:32px;">⚠️ Delete this file after use: <code>generate-descriptions.php</code></p>
</body>
</html>
