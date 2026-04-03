// Simulated Database Output matching SQL
const database = {
    sections: {
        "home": {
            id: 1,
            title: "Home",
            content: `
                <section class="deadline-band">
                    Paper Submission Hard Deadline: 30th August 2026 (No Extensions)
                </section>
                <section class="hero-section">
                    <p class="hero-theme">Theme: AI in Secure and Resilient Digital Infrastructure</p>
                    <h1 class="hero-title">2nd International Conference on Advances in Artificial Intelligence for Society</h1>
                    <p class="hero-date">📅 December 11-12, 2026</p>
                    <p class="hero-venue">Venue: Ramada Hotel, Dehradun, India</p>
                    <p class="hero-organized">Organized by Indian Institute of Information Technology Bhopal, India in collaboration with Vizja University, Warsaw, Poland.</p>
                    
                    <div class="hero-images">
                        <img src="images/conference_audience_1.png" alt="Audience Event" onerror="this.src='https://via.placeholder.com/600x400?text=Audience+1'">
                        <img src="images/conference_audience_2.png" alt="Researchers Listening" onerror="this.src='https://via.placeholder.com/600x400?text=Audience+2'">
                    </div>
                    
                    <p class="hero-theme">The conference will be organized in hybrid (online + offline) mode.</p>
                    
                    <div class="cta-buttons">
                        <button class="btn btn-primary">Call for Papers</button>
                        <button class="btn btn-primary">Call for Special Track</button>
                    </div>
                </section>
                <section class="content-section">
                    <h2 class="section-title">About the Conference</h2>
                    <p class="section-text">The 4th International conference on Machine Learning and Data Engineering (ICMLDE 2026) and 2nd International Conference on Advances in Artificial Intelligence for Society (ICA2S 2026) serve as premier interdisciplinary platforms for researchers, practitioners, and educators to present and discuss the most recent innovations, trends, and concerns in AI and Machine Learning.</p>
                    <p class="section-text" style="color: #0d6efd; font-weight: bold; text-align: center;">All accepted papers will be published in Procedia Computer Science Journal, Elsevier.</p>
                </section>
            `
        },
        "committee": {
            id: 2,
            title: "Committee",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Organizing Committee</h2>
                    <div class="grid-cards">
                        <div class="card">
                            <h3>Dr. Alice Smith</h3>
                            <p class="role">General Chair</p>
                            <p>University of Dayton</p>
                        </div>
                        <div class="card">
                            <h3>Dr. Bob Johnson</h3>
                            <p class="role">Program Chair</p>
                            <p>UPES</p>
                        </div>
                        <div class="card">
                            <h3>Dr. Carol Davis</h3>
                            <p class="role">Technical Chair</p>
                            <p>Vizja University</p>
                        </div>
                        <div class="card">
                            <h3>Dr. Ramesh Kumar</h3>
                            <p class="role">Advisory Committee</p>
                            <p>IIIT Bhopal</p>
                        </div>
                    </div>
                </section>
            `
        },
        "important_dates": {
            id: 3,
            title: "Important Dates",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Timeline & Deadlines</h2>
                    <ul class="timeline">
                        <li><strong>Paper Submission Deadline:</strong> <span>August 30, 2026</span></li>
                        <li><strong>Notification of Acceptance:</strong> <span>October 15, 2026</span></li>
                        <li><strong>Camera Ready Paper:</strong> <span>November 10, 2026</span></li>
                        <li><strong>Early Bird Registration:</strong> <span>November 15, 2026</span></li>
                        <li><strong>Conference Dates:</strong> <span>December 11-12, 2026</span></li>
                    </ul>
                </section>
            `
        },
        "speakers": {
            id: 4,
            title: "Speakers",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Keynote Speakers</h2>
                    <div class="grid-cards">
                        <div class="card">
                            <h3>Prof. Jane Doe</h3>
                            <p class="role">Keynote Speaker</p>
                            <p>Expert in Deep Learning and Neural Networks, Stanford University.</p>
                        </div>
                        <div class="card">
                            <h3>Dr. John Smith</h3>
                            <p class="role">Invited Speaker</p>
                            <p>Pioneer in AI ethics and Societal impacts, MIT.</p>
                        </div>
                    </div>
                </section>
            `
        },
        "workshop": {
            id: 5,
            title: "Workshop",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Pre-Conference Workshops</h2>
                    <p class="section-text">Join us for hands-on sessions led by industry experts and top academics.</p>
                    <div class="grid-cards">
                        <div class="card">
                            <h3>Generative AI & LLMs</h3>
                            <p class="role">Dec 10, 2026 - Morning</p>
                            <p>Focusing on the latest advancements in LLM architectures and applications.</p>
                        </div>
                        <div class="card">
                            <h3>Edge Computing in AI</h3>
                            <p class="role">Dec 10, 2026 - Afternoon</p>
                            <p>Implementing machine learning models on constrained edge devices.</p>
                        </div>
                    </div>
                </section>
            `
        },
        "submission": {
            id: 6,
            title: "Submission",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Submission Guidelines</h2>
                    <p class="section-text">Authors are invited to submit original, unpublished research papers. All submissions will be peer-reviewed based on originality, technical depth, and relevance to the conference themes.</p>
                    <p class="section-text" style="color:red; font-weight:600;">Paper Submission Hard Deadline: 30th August 2026 (No Extensions)</p>
                    <ul class="timeline" style="margin-top: 30px;">
                        <li><strong>Format:</strong> All manuscripts must follow standard standard procedural templates. Double blind review is mandatory!</li>
                        <li><strong>Page Limit:</strong> Maximum 6 pages, including figures and tables.</li>
                        <li><strong>Template:</strong> Available on the submission portal.</li>
                    </ul>
                    <div style="text-align: center; margin-top: 30px;">
                        <button class="btn btn-primary">Go To Submission Portal</button>
                    </div>
                </section>
            `
        },
        "special_session": {
            id: 7,
            title: "Special Session",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Special Sessions</h2>
                    <p class="section-text">We are delighted to feature several specialized tracks tailored for emerging technologies.</p>
                    <div class="grid-cards">
                        <div class="card">
                            <h3>SS-01: AI in Healthcare</h3>
                            <p class="role">Track Chair: Dr. Emma Watson</p>
                        </div>
                        <div class="card">
                            <h3>SS-02: Smart City Infrastructure</h3>
                            <p class="role">Track Chair: Dr. Michael Chang</p>
                        </div>
                    </div>
                </section>
            `
        },
        "registration": {
            id: 8,
            title: "Registration",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Registration Details</h2>
                    <p class="section-text">Welcome! In order to attend or present, all participants must register.</p>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Early Bird (Before Nov 15)</th>
                                <th>Regular (After Nov 15)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Student / Scholar</td>
                                <td>$200 / INR 5000</td>
                                <td>$250 / INR 6000</td>
                            </tr>
                            <tr>
                                <td>Academic / Researcher</td>
                                <td>$300 / INR 7000</td>
                                <td>$350 / INR 8000</td>
                            </tr>
                            <tr>
                                <td>Industry Professional</td>
                                <td>$400 / INR 10000</td>
                                <td>$450 / INR 11000</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            `
        },
        "sponsorship": {
            id: 9,
            title: "Sponsorship",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Sponsorship Opportunties</h2>
                    <p class="section-text">Partner with ICA2S 2026 & ICMLDE to gain unparalleled visibility among a global audience of researchers, students, and professionals.</p>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tier</th>
                                <th>Benefits</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Platinum</td>
                                <td>Logo on all materials, Prime Booth, 5 Free Passes, Keynote intro.</td>
                                <td>$5,000</td>
                            </tr>
                            <tr>
                                <td>Gold</td>
                                <td>Logo on website, Standard Booth, 3 Free Passes.</td>
                                <td>$3,000</td>
                            </tr>
                            <tr>
                                <td>Silver</td>
                                <td>Logo on website, 1 Free Pass.</td>
                                <td>$1,500</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            `
        },
        "contact": {
            id: 10,
            title: "Contact",
            content: `
                <section class="content-section">
                    <h2 class="section-title">Contact Us</h2>
                    <div class="grid-cards" style="grid-template-columns: 1fr 1fr;">
                        <div class="card" style="text-align: left;">
                            <h3>General Inquiries</h3>
                            <p style="margin-top: 10px;"><strong>Email:</strong> contact@ica2s2026.org</p>
                            <p><strong>Phone:</strong> +91 123 456 7890</p>
                        </div>
                        <div class="card" style="text-align: left;">
                            <h3>Conference Venue</h3>
                            <p style="margin-top: 10px;"><strong>Ramada Hotel</strong></p>
                            <p>Dehradun, Uttarakhand, India.</p>
                            <p>Pincode: 248001</p>
                        </div>
                    </div>
                </section>
            `
        }
    }
};

// Function to Load Sections Dynamically
function loadSection(sectionName, event) {
    if (event) event.preventDefault();
    
    // Validate if section exists
    if (!database.sections[sectionName]) {
        console.error("Section not found in DB.");
        return;
    }

    // Load content dynamically
    document.getElementById('main-content').innerHTML = database.sections[sectionName].content;

    // Highlight active menu item
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Find the link that triggered the event, or find it by mapping to add 'active'
    let menuItems = document.querySelectorAll('.nav-item');
    menuItems.forEach(item => {
        let textMatch = item.textContent.toLowerCase().replace(' ', '_');
        if(textMatch === sectionName || 
          (item.textContent === "Important Dates" && sectionName === "important_dates") || 
          (item.textContent === "Special Session" && sectionName === "special_session") || 
          (item.textContent === "Home" && sectionName === "home")) {
            item.classList.add('active');
        }
    });

    // Close mobile menu if open
    document.querySelector('.nav-links').classList.remove('active');

    // Scroll to top of content
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Mobile Menu Toggle
function toggleMenu() {
    document.querySelector('.nav-links').classList.toggle('active');
}

// Load Home on first load
window.onload = () => {
    loadSection('home');
};

// Modal Control Functions
function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

function switchModal(closeId, openId) {
    closeModal(closeId);
    openModal(openId);
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}

