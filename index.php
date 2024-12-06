<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Detective</title>
    <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
<div class="header">
    <div class="logo"></div>
    <h1 class="title">The detective</h1>
    <nav class="nav">
        <div class="dropdown">
            <span class="dropdown-trigger">Группы</span>
            <ul class="dropdown-menu"></ul>
        </div>
        <div>
            <button id="adminButton">Администрирование</button>
        </div>
    </nav>
</div>
<div class="main">
    <aside class="sidebar">
        <ul id="students-list">
        </ul>
    </aside>
    <div class="content">
        <div class="card">
            <h2>ФИО</h2>
        </div>
        <div class="card">
            <h2>ФИО</h2>
        </div>
    </div>
</div>
<div class="footer">
    <button>Сравнить</button>
</div>

<!-- Модальное окно для управления студентами и группами -->
<div id="adminModal" class="modal" style="display: none">
    <div class="modal-content">
        <h2>Управление студентами и группами</h2>
        <div class="section">
            <h3>Список студентов</h3>
            <label for="groupFilter">Выберите группу:</label>
            <select id="groupFilter" class="form-control">
                <option value="">Все группы</option>
                <!-- Группы будут динамически добавляться здесь -->
            </select>
            <table id="studentsTable">
                <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Группа</th>
                    <th>Github ID</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Форма для добавления/редактирования студентов -->
        <div class="section">
            <form id="studentForm">
                <input type="hidden" id="studentId" name="id" />
                <div>
                    <label for="studentName">ФИО:</label>
                    <input type="text" id="studentName" name="name" required />
                </div>
                <div>
                    <label for="studentGithubId">Github ID:</label>
                    <input type="text" id="studentGithubId" name="githubid" required />
                </div>
                <div>
                    <label for="groupSelect">Группа:</label>
                    <select id="groupSelect" name="groupid">
                    </select>
                </div>
                <div class="buttons">
                    <button type="submit" class="btn js-submitStudent">Добавить</button>
                    <button type="button" class="btn js-resetStudent">Сбросить</button>
                </div>
            </form>
        </div>

        <div class="section">
            <h3>Список групп</h3>
            <table id="groupsTable">
                <thead>
                <tr>
                    <th>Название группы</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Форма для добавления/редактирования группы -->
        <div class="section">
            <form id="groupForm">
                <input type="hidden" id="groupId" name="id" />
                <div>
                    <label for="groupName">Название группы:</label>
                    <input type="text" id="groupName" name="name" required />
                </div>
                <div class="buttons">
                    <button type="submit" class="btn js-submitGroup">Добавить</button>
                    <button type="button" class="btn js-resetGroup">Сбросить</button>
                </div>
            </form>
        </div>

        <button id="closeModal" class="close-button">X</button>
    </div>
</div>
<script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
<script src="./assets/lib.js"></script>
<script src="./assets/main.js"></script>
</body>
</html>
