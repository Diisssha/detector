$(document).ready(function () {
    fetchGroups();
    // Открытие модального окна
    $('#adminButton').on('click', function () {
        fetchGroups();
        $('#adminModal').fadeIn();
    });

    // Закрытие модального окна
    $('#closeModal').on('click', function () {
        $('#adminModal').fadeOut();
    });

    $('#studentForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: './core/saveStudent.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                const data = JSON.parse(response);

                if (data.success) {
                    alert('Данные успешно сохранены');
                    fetchStudents();
                    resetForm();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Ошибка сохранения данных: ' + error);
            }
        });
    });

    $(document).on('click', '.edit-button', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const githubid = $(this).data('githubid');

        //очистка группы здесь тоже нужна
        $('#studentId').val(id);
        $('#studentName').val(name);
        $('#studentGithubId').val(githubid);
        $('.js-submitStudent').text('Обновить');
    });

    $(document).on('click', '.delete-button', function () {
        const id = $(this).data('id');
        if (confirm('Вы уверены, что хотите удалить этого студента?')) {
            $.ajax({
                url: './core/deleteStudent.php',
                method: 'POST',
                data: { id },
                success: function () {
                    alert('Студент удален');
                    fetchStudents();  // Обновляем таблицу после удаления
                },
                error: function (xhr, status, error) {
                    alert('Ошибка удаления: ' + error);
                }
            });
        }
    });

    $('#groupForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: './core/saveGroup.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Группа успешно сохранена');
                    fetchStudents();
                    fetchGroups();  // Обновляем список групп
                    resetGroupForm();
                    $('#groupForm')[0].reset();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Ошибка сохранения группы: ' + error);
            }
        });
    });

    $(document).on('click', '.delete-group', function () {
        const id = $(this).data('id');
        if (confirm('Вы уверены, что хотите удалить эту группу?')) {
            $.ajax({
                url: './core/deleteGroup.php',
                method: 'POST',
                data: { id },
                success: function () {
                    alert('Группа удалена');
                    fetchGroups();  // Обновляем список групп
                    fetchStudents();
                },
                error: function (xhr, status, error) {
                    alert('Ошибка удаления группы: ' + error);
                }
            });
        }
    });

    $(document).on('click', '.edit-group', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#groupId').val(id);
        $('#groupName').val(name);
        $('.js-submitGroup').text('Обновить');
    });

    $(document).on('click', '.dropdown-menu li', function () {
        const selectedGroupName = $(this).text(); //название группы из свойства text
        /*
        тут добавить ajax к серверу с выборкой студентов в этой группе и добавлению их в правое поле
        (писать ещё id студента в аттрибут st-id чтобы потом можно было дергать репы определенных студентов
        по их GithubID
        */
        //например:
        $('#students-list').append('<li>' + selectedGroupName + '</li>');
    });

    $(document).on('change', '#groupFilter', function () {
        var groupId = $(this).val();
        fetchStudents(groupId);
    });

    $(document).on('click', '.js-resetStudent', function () {
        resetForm();
    });

    $(document).on('click', '.js-resetGroup', function () {
        resetGroupForm();
    });
});
