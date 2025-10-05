<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $providers = User::where('role', 'provider')->get();

        $courses = [
            // 1
            [
                'title' => 'Full Stack Web Development Bootcamp',
                'description' => 'Learn modern web development from frontend to backend: HTML, CSS, JavaScript, React, Node.js, and MongoDB.',
                'field' => 'Programming',
                'city' => 'Cairo',
                'price' => 2500.00,
                'duration' => 120,
                'status' => 'approved',
                'max_students' => 30,
                'start_date' => '2024-02-01',
                'level' => 'intermediate',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 45,
                'total_projects' => 5,
                'total_assignments' => 12,
                'learning_outcomes' => [
                    'Build responsive websites using HTML5, CSS3, and JavaScript',
                    'Create dynamic single-page applications with React',
                    'Develop RESTful APIs using Node.js',
                    'Work with MongoDB for database operations',
                    'Deploy full-stack applications to cloud platforms'
                ],
                'requirements' => [
                    'Basic computer literacy',
                    'Personal laptop with internet',
                    'No prior programming experience required'
                ],
                'target_audience' => 'Career changers, freelancers, entrepreneurs, and students.',
                'course_highlights' => [
                    '5 real-world projects',
                    'Job guidance',
                    'Live coding sessions',
                    'Access to developer community'
                ]
            ],
            // 2
            [
                'title' => 'Digital Marketing Masterclass 2024',
                'description' => 'Master SEO, social media, Google Ads, content marketing, and analytics with hands-on projects.',
                'field' => 'Marketing',
                'city' => 'Alexandria',
                'price' => 1800.00,
                'duration' => 80,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-02-15',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 32,
                'total_projects' => 3,
                'total_assignments' => 8,
                'learning_outcomes' => [
                    'Create marketing strategies',
                    'Run SEO and social media campaigns',
                    'Analyze marketing performance',
                    'Master Google Ads and email funnels'
                ],
                'requirements' => [
                    'Basic social media knowledge',
                    'Computer with internet',
                    'Willingness to practice on platforms'
                ],
                'target_audience' => 'Business owners, marketing professionals, students.',
                'course_highlights' => [
                    'Live campaigns',
                    'Real advertising budgets',
                    'Certifications and networking'
                ]
            ],
            // 3
            [
                'title' => 'Data Science & Machine Learning with Python',
                'description' => 'Comprehensive data science program covering Python, statistics, ML algorithms, and data visualization.',
                'field' => 'Data Science',
                'city' => 'Cairo',
                'price' => 3000.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-03-01',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 50,
                'total_projects' => 6,
                'total_assignments' => 15,
                'learning_outcomes' => [
                    'Master Python programming',
                    'Perform statistical analysis',
                    'Build and evaluate ML models',
                    'Create data visualizations',
                    'Deploy ML models'
                ],
                'requirements' => [
                    'Basic programming knowledge',
                    'High school math & statistics',
                    'Computer with 8GB RAM'
                ],
                'target_audience' => 'Developers, analysts, researchers, students.',
                'course_highlights' => [
                    'Real datasets',
                    'Internship opportunities',
                    'GPU-accelerated sessions',
                    'Portfolio development'
                ]
            ],
            // 4
            [
                'title' => 'Mobile App Development with React Native',
                'description' => 'Build cross-platform mobile apps for iOS & Android with React Native.',
                'field' => 'Programming',
                'city' => 'Giza',
                'price' => 2200.00,
                'duration' => 90,
                'status' => 'pending',
                'max_students' => 25,
                'start_date' => '2024-03-15',
                'level' => 'intermediate',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 36,
                'total_projects' => 4,
                'total_assignments' => 10,
                'learning_outcomes' => [
                    'Build mobile apps for iOS & Android',
                    'Use Redux for state management',
                    'Integrate with REST APIs',
                    'Deploy apps to App Store & Play Store'
                ],
                'requirements' => [
                    'JavaScript & React knowledge',
                    'Mac for iOS testing',
                    'Android device or emulator'
                ],
                'target_audience' => 'React developers, mobile enthusiasts, entrepreneurs.',
                'course_highlights' => [
                    '4 complete mobile apps',
                    'App store submission guidance',
                    'Performance optimization'
                ]
            ],
            // 5
            [
                'title' => 'UI/UX Design Fundamentals & Prototyping',
                'description' => 'Learn design thinking, wireframing, prototyping, and user research.',
                'field' => 'Design',
                'city' => 'Cairo',
                'price' => 1500.00,
                'duration' => 60,
                'status' => 'approved',
                'max_students' => 35,
                'start_date' => '2024-02-20',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 28,
                'total_projects' => 4,
                'total_assignments' => 6,
                'learning_outcomes' => [
                    'Design wireframes & interactive prototypes',
                    'Conduct user research & usability testing',
                    'Master Figma & Adobe XD',
                    'Build design systems'
                ],
                'requirements' => [
                    'No design experience required',
                    'Computer with design software'
                ],
                'target_audience' => 'Aspiring designers, developers, entrepreneurs.',
                'course_highlights' => [
                    'Real client projects',
                    'Portfolio workshop',
                    'Design critique sessions'
                ]
            ],
            // 6
            [
                'title' => 'Cybersecurity Fundamentals & Ethical Hacking',
                'description' => 'Learn network security, ethical hacking, penetration testing, and security best practices.',
                'field' => 'Cybersecurity',
                'city' => 'Cairo',
                'price' => 2800.00,
                'duration' => 95,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-02-25',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 42,
                'total_projects' => 5,
                'total_assignments' => 12,
                'learning_outcomes' => [
                    'Network security fundamentals',
                    'Perform ethical hacking',
                    'Implement security protocols',
                    'Use security tools'
                ],
                'requirements' => [
                    'Basic networking knowledge',
                    'Linux familiarity',
                    'Analytical thinking'
                ],
                'target_audience' => 'IT professionals, developers, network admins.',
                'course_highlights' => [
                    'Hands-on labs',
                    'Certification prep',
                    'Expert speakers'
                ]
            ],
            // 7
            [
                'title' => 'Cloud Computing with AWS',
                'description' => 'Learn cloud fundamentals, AWS services, and deploy applications in the cloud.',
                'field' => 'Cloud',
                'city' => 'Cairo',
                'price' => 3200.00,
                'duration' => 90,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-04-01',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 40,
                'total_projects' => 5,
                'total_assignments' => 10,
                'learning_outcomes' => [
                    'Understand cloud computing concepts',
                    'Deploy applications on AWS',
                    'Manage AWS services and infrastructure',
                    'Implement security and compliance'
                ],
                'requirements' => [
                    'Basic IT knowledge',
                    'Computer with internet access'
                ],
                'target_audience' => 'Developers, IT admins, cloud enthusiasts.',
                'course_highlights' => [
                    'Hands-on AWS labs',
                    'Industry-recognized AWS projects',
                    'Preparation for AWS certification'
                ]
            ],
            // 8
            [
                'title' => 'Artificial Intelligence with Python',
                'description' => 'Learn AI concepts, neural networks, deep learning, and implement AI projects in Python.',
                'field' => 'AI',
                'city' => 'Giza',
                'price' => 3500.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-04-10',
                'level' => 'advanced',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 55,
                'total_projects' => 7,
                'total_assignments' => 15,
                'learning_outcomes' => [
                    'Implement machine learning and deep learning models',
                    'Work with neural networks',
                    'Build AI applications in Python',
                    'Analyze data using AI techniques'
                ],
                'requirements' => [
                    'Python programming knowledge',
                    'Mathematics for AI',
                    'Computer with high RAM'
                ],
                'target_audience' => 'Developers, researchers, data scientists.',
                'course_highlights' => [
                    'AI projects portfolio',
                    'Hands-on coding labs',
                    'Advanced AI concepts'
                ]
            ],
            // 9
            [
                'title' => 'Project Management Professional (PMP) Exam Prep',
                'description' => 'Prepare for PMP certification with real-life project case studies, exam techniques, and simulations.',
                'field' => 'Management',
                'city' => 'Cairo',
                'price' => 2700.00,
                'duration' => 80,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-03-20',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 30,
                'total_projects' => 3,
                'total_assignments' => 5,
                'learning_outcomes' => [
                    'Understand PMBOK framework',
                    'Manage projects effectively',
                    'Pass PMP certification'
                ],
                'requirements' => [
                    'Basic project management knowledge',
                    'Experience in projects'
                ],
                'target_audience' => 'Project managers, team leads, professionals.',
                'course_highlights' => [
                    'Practice exams',
                    'Real-world project scenarios',
                    'Exam tips & techniques'
                ]
            ],
            // 10
            [
                'title' => 'Advanced Java Programming',
                'description' => 'Deep dive into Java programming, OOP concepts, data structures, multithreading, and Java frameworks.',
                'field' => 'Programming',
                'city' => 'Alexandria',
                'price' => 2800.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-03-25',
                'level' => 'advanced',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 50,
                'total_projects' => 5,
                'total_assignments' => 12,
                'learning_outcomes' => [
                    'Master Java OOP concepts',
                    'Work with data structures and algorithms',
                    'Build Java applications using frameworks'
                ],
                'requirements' => [
                    'Basic Java knowledge',
                    'Computer with Java installed'
                ],
                'target_audience' => 'Java developers, students, programmers.',
                'course_highlights' => [
                    'Hands-on projects',
                    'Multithreading practice',
                    'Framework-based application development'
                ]
            ],
            // 11
            [
                'title' => 'Python for Beginners',
                'description' => 'Learn Python from scratch, programming basics, loops, functions, and data handling.',
                'field' => 'Programming',
                'city' => 'Cairo',
                'price' => 1500.00,
                'duration' => 60,
                'status' => 'approved',
                'max_students' => 40,
                'start_date' => '2024-02-28',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 25,
                'total_projects' => 2,
                'total_assignments' => 5,
                'learning_outcomes' => [
                    'Understand Python basics',
                    'Write simple Python scripts',
                    'Handle files and data'
                ],
                'requirements' => [
                    'No prior programming knowledge',
                    'Computer with Python installed'
                ],
                'target_audience' => 'Students, beginners, hobbyists.',
                'course_highlights' => [
                    'Hands-on exercises',
                    'Simple projects',
                    'Python foundations'
                ]
            ],
            // 12
            [
                'title' => 'Advanced Excel for Data Analysis',
                'description' => 'Master Excel tools for data analysis, pivot tables, VBA, and advanced formulas.',
                'field' => 'Data Science',
                'city' => 'Cairo',
                'price' => 1200.00,
                'duration' => 50,
                'status' => 'approved',
                'max_students' => 30,
                'start_date' => '2024-03-05',
                'level' => 'advanced',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 30,
                'total_projects' => 3,
                'total_assignments' => 7,
                'learning_outcomes' => [
                    'Advanced Excel formulas',
                    'Pivot tables and charts',
                    'Data analysis and reporting'
                ],
                'requirements' => [
                    'Basic Excel knowledge',
                    'Computer with Excel installed'
                ],
                'target_audience' => 'Business analysts, students, professionals.',
                'course_highlights' => [
                    'Hands-on exercises',
                    'Advanced data analysis',
                    'Real-world case studies'
                ]
            ],
            // 13
            [
                'title' => 'Introduction to Graphic Design',
                'description' => 'Learn design principles, color theory, typography, and basic Photoshop and Illustrator skills.',
                'field' => 'Design',
                'city' => 'Giza',
                'price' => 1400.00,
                'duration' => 60,
                'status' => 'approved',
                'max_students' => 35,
                'start_date' => '2024-02-18',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 28,
                'total_projects' => 3,
                'total_assignments' => 6,
                'learning_outcomes' => [
                    'Design basics',
                    'Photoshop and Illustrator fundamentals',
                    'Create simple graphics and posters'
                ],
                'requirements' => [
                    'Computer with Adobe Suite',
                    'Interest in design'
                ],
                'target_audience' => 'Aspiring designers, students, hobbyists.',
                'course_highlights' => [
                    'Hands-on projects',
                    'Portfolio building',
                    'Design principles'
                ]
            ],
            // 14
            [
                'title' => 'Social Media Management & Growth',
                'description' => 'Learn to manage social media accounts, grow audience, create content, and analyze performance.',
                'field' => 'Marketing',
                'city' => 'Alexandria',
                'price' => 1600.00,
                'duration' => 70,
                'status' => 'approved',
                'max_students' => 30,
                'start_date' => '2024-03-10',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 26,
                'total_projects' => 3,
                'total_assignments' => 5,
                'learning_outcomes' => [
                    'Content creation',
                    'Social media growth strategies',
                    'Analytics and performance tracking'
                ],
                'requirements' => [
                    'Basic social media knowledge',
                    'Computer with internet'
                ],
                'target_audience' => 'Freelancers, marketing students, business owners.',
                'course_highlights' => [
                    'Hands-on practice',
                    'Real-life social media projects',
                    'Growth strategies'
                ]
            ],
            // 15
            [
                'title' => 'AWS Cloud Practitioner Essentials',
                'description' => 'Learn cloud basics, AWS global infrastructure, services overview, and basic cloud deployment.',
                'field' => 'Cloud',
                'city' => 'Cairo',
                'price' => 2000.00,
                'duration' => 60,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-04-05',
                'level' => 'beginner',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 28,
                'total_projects' => 2,
                'total_assignments' => 5,
                'learning_outcomes' => [
                    'Understand AWS cloud concepts',
                    'Navigate AWS services',
                    'Deploy basic applications'
                ],
                'requirements' => [
                    'Basic IT knowledge',
                    'Computer with internet access'
                ],
                'target_audience' => 'IT beginners, students, professionals.',
                'course_highlights' => [
                    'Hands-on labs',
                    'AWS practice projects',
                    'Cloud fundamentals'
                ]
            ],
            // 16
            [
                'title' => 'Deep Learning with TensorFlow',
                'description' => 'Learn deep learning concepts, neural networks, CNNs, RNNs, and implement models using TensorFlow.',
                'field' => 'AI',
                'city' => 'Giza',
                'price' => 3600.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-04-12',
                'level' => 'advanced',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 55,
                'total_projects' => 6,
                'total_assignments' => 15,
                'learning_outcomes' => [
                    'Implement neural networks',
                    'Work with deep learning frameworks',
                    'Build AI applications with TensorFlow'
                ],
                'requirements' => [
                    'Python programming',
                    'Math for ML',
                    'Laptop with GPU recommended'
                ],
                'target_audience' => 'Developers, AI enthusiasts, researchers.',
                'course_highlights' => [
                    'Hands-on coding labs',
                    'Real-world AI projects',
                    'Deep learning expertise'
                ]
            ],
            // 17
            [
                'title' => 'Introduction to SQL & Databases',
                'description' => 'Learn SQL fundamentals, database design, queries, joins, and working with relational databases.',
                'field' => 'Data Science',
                'city' => 'Cairo',
                'price' => 1400.00,
                'duration' => 60,
                'status' => 'approved',
                'max_students' => 30,
                'start_date' => '2024-03-08',
                'level' => 'beginner',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 25,
                'total_projects' => 2,
                'total_assignments' => 5,
                'learning_outcomes' => [
                    'Create and manage databases',
                    'Write SQL queries',
                    'Perform database operations'
                ],
                'requirements' => [
                    'Computer basics',
                    'Interest in databases'
                ],
                'target_audience' => 'Students, data analysts, beginners.',
                'course_highlights' => [
                    'Hands-on SQL projects',
                    'Practical database experience'
                ]
            ],
            // 18
            [
                'title' => 'iOS App Development with Swift',
                'description' => 'Learn to build native iOS apps using Swift, Xcode, and UIKit.',
                'field' => 'Programming',
                'city' => 'Giza',
                'price' => 2800.00,
                'duration' => 90,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-03-22',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 40,
                'total_projects' => 4,
                'total_assignments' => 8,
                'learning_outcomes' => [
                    'Build native iOS apps',
                    'Work with Swift and Xcode',
                    'Design interactive UI',
                    'Submit apps to App Store'
                ],
                'requirements' => [
                    'Basic programming knowledge',
                    'Mac computer'
                ],
                'target_audience' => 'Mobile developers, students, hobbyists.',
                'course_highlights' => [
                    'Hands-on iOS projects',
                    'App deployment guidance',
                    'UI design best practices'
                ]
            ],
            // 19
            [
                'title' => 'Google Analytics & SEO Mastery',
                'description' => 'Learn to analyze website traffic, optimize SEO, and increase conversions using Google tools.',
                'field' => 'Marketing',
                'city' => 'Cairo',
                'price' => 1600.00,
                'duration' => 70,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-03-12',
                'level' => 'intermediate',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 30,
                'total_projects' => 3,
                'total_assignments' => 6,
                'learning_outcomes' => [
                    'Track website traffic',
                    'Perform SEO optimization',
                    'Use Google Analytics effectively'
                ],
                'requirements' => [
                    'Computer with internet',
                    'Basic website knowledge'
                ],
                'target_audience' => 'Digital marketers, business owners, students.',
                'course_highlights' => [
                    'Hands-on projects',
                    'Real-world SEO strategies'
                ]
            ],
            // 20
            [
                'title' => 'Kotlin for Android Development',
                'description' => 'Develop native Android apps using Kotlin programming language and Android Studio.',
                'field' => 'Programming',
                'city' => 'Alexandria',
                'price' => 2600.00,
                'duration' => 90,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-04-02',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 38,
                'total_projects' => 4,
                'total_assignments' => 8,
                'learning_outcomes' => [
                    'Build native Android apps',
                    'Master Kotlin programming',
                    'Integrate APIs and databases'
                ],
                'requirements' => [
                    'Basic Java or Kotlin knowledge',
                    'Computer with Android Studio'
                ],
                'target_audience' => 'Android developers, students, hobbyists.',
                'course_highlights' => [
                    'Hands-on projects',
                    'App deployment guidance',
                    'Kotlin best practices'
                ]
            ],
            // 21
            [
                'title' => 'Graphic Design Advanced Techniques',
                'description' => 'Learn advanced Photoshop, Illustrator, branding, and design portfolio creation.',
                'field' => 'Design',
                'city' => 'Cairo',
                'price' => 2000.00,
                'duration' => 80,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-04-08',
                'level' => 'advanced',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 35,
                'total_projects' => 4,
                'total_assignments' => 8,
                'learning_outcomes' => [
                    'Advanced Photoshop & Illustrator techniques',
                    'Branding and visual identity',
                    'Portfolio building'
                ],
                'requirements' => [
                    'Basic design skills',
                    'Computer with Adobe Suite'
                ],
                'target_audience' => 'Designers, students, professionals.',
                'course_highlights' => [
                    'Portfolio-ready projects',
                    'Branding exercises',
                    'Expert design tips'
                ]
            ],
            // 22
            [
                'title' => 'Machine Learning with Python & Scikit-learn',
                'description' => 'Learn supervised and unsupervised machine learning algorithms and apply them to real datasets.',
                'field' => 'AI',
                'city' => 'Giza',
                'price' => 3300.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-04-15',
                'level' => 'advanced',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 50,
                'total_projects' => 6,
                'total_assignments' => 12,
                'learning_outcomes' => [
                    'Implement ML algorithms',
                    'Analyze datasets',
                    'Build predictive models'
                ],
                'requirements' => [
                    'Python programming knowledge',
                    'Mathematics background',
                    'Computer with 8GB RAM'
                ],
                'target_audience' => 'Data scientists, developers, researchers.',
                'course_highlights' => [
                    'Hands-on projects',
                    'ML algorithms practice',
                    'Portfolio-ready models'
                ]
            ],
            // 23
            [
                'title' => 'Business Analytics with Excel & Power BI',
                'description' => 'Analyze business data, create dashboards, and visualize insights using Excel and Power BI.',
                'field' => 'Data Science',
                'city' => 'Cairo',
                'price' => 2200.00,
                'duration' => 80,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-03-28',
                'level' => 'intermediate',
                'language' => 'Arabic',
                'has_certificate' => true,
                'total_lectures' => 35,
                'total_projects' => 3,
                'total_assignments' => 7,
                'learning_outcomes' => [
                    'Business data analysis',
                    'Create dashboards',
                    'Power BI data visualization'
                ],
                'requirements' => [
                    'Basic Excel knowledge',
                    'Computer with Excel & Power BI'
                ],
                'target_audience' => 'Business analysts, students, professionals.',
                'course_highlights' => [
                    'Dashboard projects',
                    'Real business data',
                    'Data storytelling'
                ]
            ],
            // 24
            [
                'title' => 'Frontend Development with React & TypeScript',
                'description' => 'Build scalable web applications using React and TypeScript, including hooks, state management, and routing.',
                'field' => 'Programming',
                'city' => 'Giza',
                'price' => 2700.00,
                'duration' => 90,
                'status' => 'approved',
                'max_students' => 25,
                'start_date' => '2024-04-05',
                'level' => 'intermediate',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 40,
                'total_projects' => 5,
                'total_assignments' => 10,
                'learning_outcomes' => [
                    'Develop modern React applications',
                    'Implement TypeScript for type safety',
                    'Use state management and routing effectively'
                ],
                'requirements' => [
                    'JavaScript knowledge',
                    'Basic React understanding'
                ],
                'target_audience' => 'Frontend developers, students, programmers.',
                'course_highlights' => [
                    'React projects',
                    'TypeScript best practices',
                    'Component-based architecture'
                ]
            ],
            // 25
            [
                'title' => 'Blockchain & Cryptocurrency Development',
                'description' => 'Learn blockchain fundamentals, smart contracts, Ethereum, and build decentralized applications.',
                'field' => 'Programming',
                'city' => 'Cairo',
                'price' => 3500.00,
                'duration' => 100,
                'status' => 'approved',
                'max_students' => 20,
                'start_date' => '2024-04-20',
                'level' => 'advanced',
                'language' => 'English',
                'has_certificate' => true,
                'total_lectures' => 55,
                'total_projects' => 6,
                'total_assignments' => 15,
                'learning_outcomes' => [
                    'Understand blockchain concepts',
                    'Develop smart contracts',
                    'Build decentralized applications (DApps)',
                    'Deploy Ethereum-based projects'
                ],
                'requirements' => [
                    'Basic programming skills',
                    'Knowledge of JavaScript or Python'
                ],
                'target_audience' => 'Developers, blockchain enthusiasts, entrepreneurs.',
                'course_highlights' => [
                    'Hands-on blockchain projects',
                    'Smart contract development',
                    'Real-world DApp examples'
                ]
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create(array_merge($courseData, [
                'provider_id' => $providers->random()->id,
            ]));
        }
    }
}
