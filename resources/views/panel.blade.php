<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body class="h-full flex items-center justify-center">
    <nav class="w-full max-w-4xl flex flex-col items-center py-4 px-4">
        <div class="container mx-auto text-center">
            <div class="flex justify-center items-start">
                <img src="../assets/logo.png" alt="logo" class="w-1/2 sm:w-1/4">
            </div>
            <div class="radio-inputs mx-auto mt-10 grid grid-cols-2 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 p-4 lg:my-40 lg:gap-28">
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="admin">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/administrator.png" alt="admin" class="w-10 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Admin</span>
                    </span>
                </label>
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="curriculum">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/curriculum.png" alt="curriculum" class="w-10 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Curriculum</span>
                    </span>
                </label>
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="admission">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/admission.png" alt="admission" class="w-10 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Admission</span>
                    </span>
                </label>
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="teacher">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/teacher.png" alt="teacher" class="w-11 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Teacher</span>
                    </span>
                </label>
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="teacher-pg-kg">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/teacher-pg-kg.png" alt="teacher-pg-kg" class="w-10 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Teacher PG-KG</span>
                    </span>
                </label>
                <label class="flex flex-col items-center sm:p-0 sm:m-0 md:p-0 md:m-0 lg:p-4 lg:m-4">
                    <input class="radio-input" type="radio" name="engine" id="student">
                    <span class="radio-tile flex flex-col items-center">
                        <span class="radio-icon">
                            <img src="../assets/icon/students.png" alt="student" class="w-10 sm:w-16 md:w-12">
                        </span>
                        <span class="radio-label">Student</span>
                    </span>
                </label>
            </div>
        </div>
    </nav>
</body>

</html>