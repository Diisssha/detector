function fetchStudents(groupId) {
    $.ajax({
        url: '/core/getStudents.php',
        method: 'GET',
        data: { groupId },
        dataType: 'json',
        success: function (data) {
            const tableBody = $('#studentsTable tbody');
            tableBody.empty();
            if(data.success === false){
                alert(data.message);
            } else {
                data.forEach(student => {
                    tableBody.append(`
                        <tr>
                            <td>${student.FullName}</td>
                            <td>${student.GroupName}</td>
                            <td>${student.GithubID}</td>
                            <td>
                                <button class="edit-button" data-id="${student.id}" data-name="${student.FullName}" data-githubid="${student.GithubID}">Редактировать</button>
                                <button class="delete-button" data-id="${student.id}">Удалить</button>
                            </td>
                        </tr>
                    `);
                });
                $('.js-submitStudent').text('Добавить');
            }
        },
        error: function (xhr, status, error) {
            alert('Ошибка загрузки данных: ' + error);
        }
    });
}

function fetchGroups() {
    $.ajax({
        url: '/core/getGroups.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            const tableBody = $('#groupsTable tbody');
            const groupBody = $('#groupSelect');
            const dropDownGroups = $('.dropdown-menu');
            const dropDownSelectGroups = $('#groupFilter');
            tableBody.empty();
            groupBody.empty();
            dropDownGroups.empty();
            dropDownSelectGroups.empty();
            groupBody.append('<option value="">Выберите группу</option>');
            dropDownSelectGroups.append('<option value="">Выберите группу</option>');
            data.forEach(group => {
                tableBody.append(`
                        <tr>
                            <td>${group.GroupName}</td>
                            <td>
                                <button class="edit-group" data-id="${group.id}" data-name="${group.GroupName}">Редактировать</button>
                                <button class="delete-group" data-id="${group.id}">Удалить</button>
                            </td>
                        </tr>
                    `);
                groupBody.append('<option value="' + group.id + '">' + group.GroupName + '</option>');
                dropDownGroups.append('<li>' + group.GroupName + '</li>');
                dropDownSelectGroups.append('<option value="' + group.id + '">' + group.GroupName + '</option>');
            });
        },
        error: function (xhr, status, error) {
            alert('Ошибка загрузки групп: ' + error);
        }
    });
}
function resetGroupForm() {
    $('#groupForm')[0].reset();
    $('#groupId').val('');
    $('.js-submitGroup  ').text('Добавить');
}
function resetForm() {
    $('#studentForm')[0].reset();
    $('#studentId').val('');
    $('.js-submitStudent').text('Добавить');
};