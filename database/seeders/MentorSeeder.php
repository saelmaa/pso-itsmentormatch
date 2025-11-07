<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mentor;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        // $mentors = [
        //     [
        //         'name' => 'Sarah Ardini',
        //         'email' => 'sarah.ardini@its.ac.id',
        //         'department' => 'Information System',
        //         'expertise' => 'Data Science & Machine Learning',
        //         'bio' => 'Sarah Ardini is an experienced data scientist with over 8 years of experience in industry and academia. She specializes in machine learning algorithms, data visualization, and statistical analysis.',
        //         'experience_years' => 8,
        //         'rating' => 4.9,
        //         'total_sessions' => 150,
        //         'total_reviews' => 142,
        //         'availability_status' => 'available',
        //         'skills' => json_encode(['Python', 'TensorFlow', 'Data Analysis', 'Research Methods', 'Machine Learning', 'Statistics']),
        //         'location' => 'Surabaya',
        //         'price' => 'Free'
        //     ],
        //     [
        //         'name' => 'Ahmad Rizki',
        //         'email' => 'ahmad.rizki@its.ac.id',
        //         'department' => 'Informatics',
        //         'expertise' => 'Full Stack Web Development',
        //         'bio' => 'Ahmad Rizki is a senior software engineer with extensive experience in modern web development. He has worked on various projects ranging from e-commerce platforms to enterprise applications.',
        //         'experience_years' => 5,
        //         'rating' => 4.8,
        //         'total_sessions' => 120,
        //         'total_reviews' => 115,
        //         'availability_status' => 'available',
        //         'skills' => json_encode(['React', 'Node.js', 'MongoDB', 'JavaScript', 'TypeScript', 'Express.js']),
        //         'location' => 'Jakarta',
        //         'price' => 'Free'
        //     ],
        //     [
        //         'name' => 'Maria Santos',
        //         'email' => 'maria.santos@its.ac.id',
        //         'department' => 'Visual Communication Design',
        //         'expertise' => 'UI/UX Design & Product Design',
        //         'bio' => 'Maria Santos is a creative designer with a passion for user-centered design solutions. She has experience in creating intuitive interfaces for mobile and web applications.',
        //         'experience_years' => 4,
        //         'rating' => 4.9,
        //         'total_sessions' => 95,
        //         'total_reviews' => 89,
        //         'availability_status' => 'busy',
        //         'skills' => json_encode(['Figma', 'Adobe XD', 'User Research', 'Prototyping', 'Design Systems', 'Usability Testing']),
        //         'location' => 'Bandung',
        //         'price' => 'Free'
        //     ],
        //     [
        //         'name' => 'Budi Santoso',
        //         'email' => 'budi.santoso@its.ac.id',
        //         'department' => 'Informatics',
        //         'expertise' => 'DevOps & Cloud Computing',
        //         'bio' => 'Budi Santoso is a cloud architecture specialist with extensive experience in AWS and containerization technologies. He has helped numerous organizations migrate to the cloud and implement CI/CD pipelines.',
        //         'experience_years' => 6,
        //         'rating' => 4.7,
        //         'total_sessions' => 80,
        //         'total_reviews' => 76,
        //         'availability_status' => 'available',
        //         'skills' => json_encode(['AWS', 'Docker', 'Kubernetes', 'CI/CD', 'Terraform', 'Linux']),
        //         'location' => 'Surabaya',
        //         'price' => 'Free'
        //     ],
        //     [
        //         'name' => 'Lisa Chen',
        //         'email' => 'lisa.chen@its.ac.id',
        //         'department' => 'Information System',
        //         'expertise' => 'Business Analysis & Project Management',
        //         'bio' => 'Lisa Chen is an experienced business analyst and project manager with a strong background in system analysis and requirements gathering.',
        //         'experience_years' => 7,
        //         'rating' => 4.8,
        //         'total_sessions' => 110,
        //         'total_reviews' => 105,
        //         'availability_status' => 'available',
        //         'skills' => json_encode(['Business Analysis', 'Project Management', 'Requirements Gathering', 'Agile', 'Scrum', 'BPMN']),
        //         'location' => 'Surabaya',
        //         'price' => 'Free'
        //     ],
        //     [
        //         'name' => 'Rina Wijaya',
        //         'email' => 'rina.wijaya@its.ac.id',
        //         'department' => 'Visual Communication Design',
        //         'expertise' => 'Digital Marketing & Brand Design',
        //         'bio' => 'Rina Wijaya is a creative professional specializing in digital marketing and brand design. She has worked with various clients to develop comprehensive brand strategies and digital marketing campaigns.',
        //         'experience_years' => 5,
        //         'rating' => 4.6,
        //         'total_sessions' => 85,
        //         'total_reviews' => 80,
        //         'availability_status' => 'available',
        //         'skills' => json_encode(['Adobe Creative Suite', 'Brand Design', 'Digital Marketing', 'Social Media', 'Content Strategy', 'Photography']),
        //         'location' => 'Jakarta',
        //         'price' => 'Free'
        //     ]
        // ];

        // foreach ($mentors as $mentor) {
        //     Mentor::create($mentor);
        // }

        // Generate dummy mentors dariusing factory
            try {
            Mentor::factory()->count(20)->create();
        } catch (\Exception $e) {
            dd('Seeding failed: ' . $e->getMessage());
        }
    }
}
