<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MentorFactory extends Factory
{
    protected $model = \App\Models\Mentor::class;
    
    public function __construct()
    {
        parent::__construct();
        $this->faker = \Faker\Factory::create('id_ID'); // Locale Indonesia
    }

    public function definition(): array
    {
        $departmentsData = [
            'Information System' => [
                'expertise' => ['Business Intelligence', 'Digital Transformation', 'Enterprise Systems'],
                'skills' => ['ERP', 'Business Analysis', 'Agile', 'Data Modeling', 'Project Management']
            ],
            'Informatics' => [
                'expertise' => ['Software Engineering', 'Web Development', 'AI & Machine Learning'],
                'skills' => ['Laravel', 'React', 'Python', 'Node.js', 'TensorFlow']
            ],
            'Visual Communication Design' => [
                'expertise' => ['UI/UX Design', 'Graphic Design', 'Product Design'],
                'skills' => ['Figma', 'Adobe XD', 'Sketch', 'Prototyping', 'Illustrator']
            ],
            'Electrical Engineering' => [
                'expertise' => ['Embedded Systems', 'IoT', 'Power Systems'],
                'skills' => ['Arduino', 'MATLAB', 'PLC', 'Circuit Design', 'IoT']
            ],
            'Mechanical Engineering' => [
                'expertise' => ['CAD Design', 'Thermodynamics', 'Fluid Mechanics'],
                'skills' => ['SolidWorks', 'ANSYS', 'AutoCAD', 'CFD', 'MATLAB']
            ],
            'Civil Engineering' => [
                'expertise' => ['Structural Engineering', 'Construction Management', 'Transportation'],
                'skills' => ['SAP2000', 'ETABS', 'AutoCAD Civil 3D', 'Surveying', 'Primavera']
            ]
        ];

        $department = $this->faker->randomElement(array_keys($departmentsData));
        $expertise = $this->faker->randomElement($departmentsData[$department]['expertise']);
        $skills = $this->faker->randomElements($departmentsData[$department]['skills'], 5);

        $cities = [
            'Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang', 'Malang',
            'Medan', 'Makassar', 'Palembang', 'Balikpapan'
        ];

        $bios = [
            'A passionate mentor with hands-on industry experience.',
            'Committed to guiding students through practical knowledge and insights.',
            'Experienced in academic teaching and real-world applications.',
            'Driven by a desire to help future professionals grow and succeed.',
            'Combining years of technical experience with a love for education.'
        ];

        $name = $this->faker->name();
        $slugName = Str::slug($name, '.');

        return [
            'name' => $name,
            'email' => Str::slug($name, '.') . '.' . $this->faker->unique()->numberBetween(100, 999) . '@its.ac.id',
            'department' => $department,
            'expertise' => $expertise,
            'bio' => $this->faker->randomElement($bios) . ' Specializes in ' . strtolower($expertise) . '.',
            'experience_years' => $this->faker->numberBetween(3, 15),
            'rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'total_sessions' => $this->faker->numberBetween(30, 200),
            'total_reviews' => $this->faker->numberBetween(20, 190),
            'availability_status' => $this->faker->randomElement(['available', 'busy']),
            'skills' => $skills,
            'location' => $this->faker->randomElement($cities),
            'price' => 'Free'
        ];
    }
}
