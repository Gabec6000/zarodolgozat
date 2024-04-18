<?php
    if (!isset($_SESSION['user'])) logout();
    if (!($_SESSION['permission'] > 0)) header('location: index.php?home');

    $last10 = get_last10_reg();
    $last10_2 = get_last10_posts();
    $topics = get_topics();
?>

<div class="row">
    <div class="col-12 col-md-4 card">
        <h5>Utolsó 10 regisztráció</h5>
        <div class="card-body">
            <table class="table table-striped" id="last10">
                <tr>
                    <th>id</th>
                    <th>fh.név</th>
                    <th>link</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-12 col-md-4 card">
        <h5>Utolsó 10 bejegyzés</h5>
        <div class="card-body">
        <table class="table table-striped" id="last10_2">
                <tr>
                    <th>id</th>
                    <th>cím</th>
                    <th>téma</th>
                    <th>link</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-12 col-md-4 card">
        <h5>Témák</h5>
        <a href="?addtopic">[új hozzáadása]</a>
        <div class="card-body">
        <table class="table table-striped" id="topics">
                <tr>
                    <th>id</th>
                    <th>név</th>
                    <th>opciók</th>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
    const last10 = <?php echo json_encode($last10); ?>;
    const last10_2 = <?php echo json_encode($last10_2); ?>;
    const topics = <?php echo json_encode($topics); ?>;
    const last10el = document.getElementById('last10');
    const last10el_2 = document.getElementById('last10_2');
    const topics_el = document.getElementById('topics');

    window.onload = () => {
        for (var it of last10)
        {
            last10el.innerHTML += `
                <tr>
                    <td>${it.id}</td>
                    <td>${it.username}</td>
                    <td><a href="?profile&id=${it.id}">[ugrás]</a></td>
                </tr>
            `
        }

        for (var it of last10_2)
        {
            last10el_2.innerHTML += `
                <tr>
                    <td>${it.id}</td>
                    <td>${it.title}</td>
                    <td>${it.name}</td>
                    <td><a href="?viewpost&id=${it.id}">[ugrás]</a></td>
                </tr>
            `
        }

        for (var it of topics)
        {
            topics_el.innerHTML += `
                <tr>
                    <td>${it.id}</td>
                    <td>${it.name}</td>
                    <td><a href="#" onclick="deleteTopic(${it.id})">[törlés]</td>
                </tr>
            `
        }
    }

    deleteTopic = (id) => {
        fetch('api.php?deleteTopic&id=' + id).then(response => {
            window.location.reload()
        })
    }

    fasz = () => {
        fetch('api.php?test').then(async x => {
            var a = await x.json()
            console.log(a)
        })
    }
</script>
