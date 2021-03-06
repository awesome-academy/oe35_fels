<?php

return [
    'seeder' => [
        'number' => 10,
        'role_id' => 3,
    ],
    'pagination' => [
        'course' => 6,
        'course_word' => 10,
        'word' => 10,
    ],
    'learned' => '1',
    'n_a' => 'N/A',
    'order_score' => 'DESC',
    'gender' => [
        'male' => '1',
        'female' => '0',
    ],
    'default_avatar' => 'avatar.png',
    'profile_path' => public_path('/profile/'),
    'avatar_link' => public_path('/profile/avatar.png'),
    'order_course' => 'ASC',
    'year' => '2020',
    'correct_answer' => '1',
    'provider' => [
        'google',
    ],
    'exam_time' => '10', // minutes
    'locale' => [
        'vi' => 'vi',
        'en' => 'en',
    ],
    'mail' => [
        'admin' => 'admin@mail.com',
        'name' => 'Admin',
    ],
    'job' => [
        'tries' => 3,
        'timeout' => 30,
    ],
    'role' => [
        'super_admin' => 1,
        'admin' => 2,
        'user' => 3,
    ],
];
