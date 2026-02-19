<!-- I modified this to let this page use only style_index.css file - Gino-->
<?php
$page_css = "css/style_index.css";
include 'header.php';
?>
<!-- 0000000000000000000000000000000000000000000-->

<div class="contact-page">
    <div class="contact-wrap">

        <!-- Offices Information -->
        <div class="offices-block">
        <h2 class="offices-title">Our Offices</h2>

        <div class="offices-grid">
            <div class="office-card">
            <h4>CNSS Tech Headquarters</h4>
            <p>Peijinkuja 10 A46,<br>02270 Espoo,<br>Finland</p>
            <p>+358 41 740 8331</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Turku</h4>
            <p>Yliopistonkatu 24 A2-4,<br>20100 Turku,<br>Finland</p>
            <p>+358 44 931 9969</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Stockholm</h4>
            <p>Drottninggatan 71D,<br>111 36 Stockholm,<br>Sweden</p>
            <p>+46 (0)70 303 13 50</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Gothenburg</h4>
            <p>Östra Hamngatan 17,<br>411 10 Gothenburg,<br>Sweden</p>
            <p>+46 (0)70 400 13 50</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Norway</h4>
            <p>Fridtjof Nansens Plass 5,<br>0160 Oslo,<br>Norway</p>
            <p>+47 23 91 03 54</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Denmark</h4>
            <p>Tromsøgade 2,<br>DK-2100 Copenhagen Ø,<br>Denmark</p>
            <p>+45 31 16 26 21</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech Germany</h4>
            <p>Rosenheimerstr. 141h,<br>81671 Munich,<br>Germany</p>
            <p>+49 89 202 052 056</p>
            <p>info(at)cnsstech.com</p>
            </div>

            <div class="office-card">
            <h4>CNSS Tech UK</h4>
            <p>The Bower, 207-211 Old St,<br>EC1V 9NR London,<br>United Kingdom</p>
            <p>info(at)cnsstech.com</p>
            </div>
        </div>
        </div>

        <!-- Contact Form -->
        <h2 class="contact-title">Contact Us</h2>

        <form class="contact-form" name="form1" method="post" action="process.php"
            onsubmit="return validateForm()" enctype="multipart/form-data">

        <div class="form-grid">
            <!-- LEFT COLUMN -->
            <div class="form-col">
            <div class="field">
                <label for="first_name">First Name <span class="req">*</span></label>
                <input type="text" id="first_name" name="first_name" class="flat-input" required>
            </div>

            <div class="field">
                <label for="last_name">Last Name <span class="req">*</span></label>
                <input type="text" id="last_name" name="last_name" class="flat-input" required>
            </div>

            <div class="field">
                <label for="company_name">Company</label>
                <input type="text" id="company_name" name="company_name" class="flat-input">
            </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="form-col">
            <div class="field">
                <label for="phone_num">Phone Number</label>
                <input type="text" id="phone_num" name="phone_num" class="flat-input">
            </div>

            <div class="field">
                <label for="email_add">Email <span class="req">*</span></label>
                <input type="email" id="email_add" name="email_add" class="flat-input" required>
            </div>

            <div class="field">
                <label for="query">Message <span class="req">*</span></label>
                <textarea id="query" name="query" class="flat-textarea" rows="4" maxlength="500" required></textarea>
            </div>
            </div>
        </div>

        <div class="consent-row">
            <label class="checkbox-line">
            <input type="checkbox" id="terms" name="terms">
            <span>
                By submitting this form, you confirm that you agree to the storing and processing of your personal data by CNSS Tech as described in the 
                <!-- Same tab: keep data via autosave -->
                <a href="privacy-policy.php" onclick="if(window.cnssSaveDraft){cnssSaveDraft();}">Privacy Policy</a>.
            </span>
            </label>
        </div>

        <div class="actions-row">
            <button type="submit" class="btn-pill" name="submit">Submit</button>
        </div>

        </form>
    </div>
    </div>

    <script>
    /* Autosave draft while typing + restore when returning (privacy policy or checkbox redirect) */
    (function () {
    const KEY = "cnss_contact_form";

    function byId(id) { return document.getElementById(id); }

    function saveDraft() {
        const data = {
        first_name: byId("first_name").value,
        last_name: byId("last_name").value,
        company_name: byId("company_name").value,
        phone_num: byId("phone_num").value,
        email_add: byId("email_add").value,
        query: byId("query").value,
        terms: byId("terms").checked
        };
        sessionStorage.setItem(KEY, JSON.stringify(data));
    }

    function restoreDraft() {
        const saved = sessionStorage.getItem(KEY);
        if (!saved) return;

        try {
        const data = JSON.parse(saved);
        if (data.first_name != null)  byId("first_name").value = data.first_name;
        if (data.last_name != null)   byId("last_name").value = data.last_name;
        if (data.company_name != null)byId("company_name").value = data.company_name;
        if (data.phone_num != null)   byId("phone_num").value = data.phone_num;
        if (data.email_add != null)   byId("email_add").value = data.email_add;
        if (data.query != null)       byId("query").value = data.query;
        if (data.terms != null)       byId("terms").checked = !!data.terms;
        } catch (e) {}
    }

    document.addEventListener("DOMContentLoaded", function () {
        restoreDraft();

        // autosave on any change/input
        const ids = ["first_name", "last_name", "company_name", "phone_num", "email_add", "query", "terms"];
        ids.forEach(id => {
        const el = byId(id);
        if (!el) return;
        el.addEventListener("input", saveDraft);
        el.addEventListener("change", saveDraft);
        });
    });

    // make available for onclick on Privacy Policy link
    window.cnssSaveDraft = saveDraft;
    })();

    /* Validation */
    function validateForm() {
    const firstName = document.getElementById("first_name").value.trim();
    const lastName  = document.getElementById("last_name").value.trim();
    const email     = document.getElementById("email_add").value.trim();
    const message   = document.getElementById("query").value.trim();
    const terms     = document.getElementById("terms").checked;

    const nameRegex  = /^[A-Za-zÀ-ÖØ-öø-ÿ]+(?:[ '-][A-Za-zÀ-ÖØ-öø-ÿ]+)*$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    if (!nameRegex.test(firstName)) {
        alert("First name contains invalid characters.");
        return false;
    }

    if (!nameRegex.test(lastName)) {
        alert("Last name contains invalid characters.");
        return false;
    }

    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (message.length < 10) {
        alert("Message must be at least 10 characters.");
        return false;
    }

    // Must tick checkbox: alert -> OK -> back to form.php, keep inputs
    if (!terms) {
        if (window.cnssSaveDraft) window.cnssSaveDraft();
        alert("You must confirm that you agree to the Privacy Policy before submitting the form.");
        window.location.href = "contactus.php";
        return false;
    }

    // valid submit: optional clear draft so old data doesn't reappear later
    sessionStorage.removeItem("cnss_contact_form");
    return true;
}
</script>

<?php include 'footer.php'; ?>