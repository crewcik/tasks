<?php
function loadTasks() {
    if (file_exists('tasks.json')) {
        return json_decode(file_get_contents('tasks.json'), true);
    }
    return [];
}

function saveTasks($tasks) {
    file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

$tasks = loadTasks();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task'])) {
        $tasks[] = ['name' => htmlspecialchars(trim($_POST['task'])), 'completed' => false];
        saveTasks($tasks);
    } elseif (isset($_POST['complete'])) {
        $index = intval($_POST['complete']);
        $tasks[$index]['completed'] = true;
        saveTasks($tasks);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew - Görev Uygulaması</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Görev Listesi</h1>
        <form method="post">
            <input type="text" name="task" placeholder="Yeni görev ekleyin" required>
            <button type="submit">Ekle</button>
        </form>

        <h2>Görevler</h2>
        <ul>
            <?php foreach ($tasks as $index => $task): ?>
                <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <?php echo $task['name']; ?>
                    <?php if (!$task['completed']): ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="complete" value="<?php echo $index; ?>">
                            <button type="submit">Tamamla</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
