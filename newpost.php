<?php
if (!isset($_SESSION['user'])) logout();

$sql = 'select * from topics';
$sth = $pdo->prepare($sql);
$sth->execute([]);
$usr = $sth->fetchAll();

$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = $_POST['title'];
    $message = $_POST['text'];
    $type = $_POST['type'];

    if (!$title || !(strlen($title)) > 0)
    {
        $error = 'Cím mező üresen maradt.';
    }
    else {
        if (!$message || !(strlen($message) > 0))
        {
            $error = 'Bejegyzés tartalma üresen maradt';
        }
        else
        {
            $sql = 'insert into posts set userid = ?, title = ?, text = ?, type = ?';
            $sth = $pdo->prepare($sql);
            $sth->execute([get_userid(), $title, str_replace("\n", "\\n", $message), $type]);
            $_a = $sth->fetchAll();
            header('location: index.php?viewpost&id='.$pdo->lastInsertId());
        }
    }
}
?>

<div w-100>
    <div>
        <form method="post">
            <input type="text" name="title" id="title" placeholder="Bejegyzés címe">
            <textarea class="w-100 mt-2" name="text" id="text" rows="10" placeholder="Bejegyzés szövege"></textarea>
            <p>Bejegyzés témája:</p>
            <select name="type" id="type">
            </select>
            <input type="submit" value="Bejegyzés közzététele" class="btn btn-success d-block mt-4">
        </form>
        <?php if ($error != '') echo '<div class="alert alert-danger mt-4">'.$error.'</div>'; ?>
    </div>
</div>

<script>
    const topics = <?php echo json_encode($usr); ?>;
    const el = document.getElementById('type')
    window.onload = () => {
        for (var it of topics) {
            el.innerHTML += `
                <option value="${it.id}">${it.name}</option>
            `
        }
    }
</script>
