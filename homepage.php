<?php
    $sql = 'select posts.id, userid, title, text, type, postdate, accounts.username, topics.name, (select count(*) as n from likes_bind where postid = posts.id) as likecount from posts inner join accounts on accounts.id = posts.userid inner join topics on topics.id = posts.type order by posts.id desc limit 10';
    $sth = $pdo->prepare($sql);
    $sth->execute([]);
    $usr = $sth->fetchAll();

    $topics = get_topics();
?>

<div class="w-100">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Keresés</h5>
                    <div class="card-text">
                        <input class="" type="text" name="searchname" id="searchname" placeholder="Keresés címben"><br>
                        <select class="my-3" name="searchtype" id="searchtype"></select>
                    </div>
                    <a href="#" class="btn btn-primary" onclick="doSearch()">Keresés</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statisztikák</h5>
                    <div class="card-text">
                        <table class="table">
                            <tr class="w-100">
                                <th>regisztrált felhasználók</th>
                                <td class="text-end"><?php echo get_registered_users(); ?></td>
                            </tr>
                            <tr class="w-100">
                                <th>legnépszerűbb téma</th>
                                <td class="text-end"><?php echo get_most_popular_topic(); ?></td>
                            </tr>
                            <tr class="w-100">
                                <th>legaktívabb felhasználó</th>
                                <td class="text-end"><?php echo get_most_active_user(); ?></td>
                            </tr>
                            <tr class="w-100">
                                <th>legtöbb likeot kapta</th>
                                <td class="text-end"><?php echo get_most_likes_got(); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3>Utolsó 10 bejegyzés:</h3>
    <div id="target"></div>
</div>

<script>
    const data = <?php echo json_encode($usr); ?>;
    const topics = <?php echo json_encode($topics); ?>;
    const el = document.getElementById('target');
    const permission = <?php echo isset($_SESSION['permission']) ? $_SESSION['permission'] : 0; ?>;

    window.onload = () => {
        for (var it of data) {
            el.innerHTML += `
                <div class="card mb-3 entry">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="scroll.png" class="img-fluid rounded-start">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title"><a href="?viewpost&id=${it.id}">${it.title}</a> <i>(${it.name})</i></h5>
                                <p class="card-text">${it.text.replace(/\\n/g, '<br>')}</p>
                                <p class="card-text"><small class="text-body-secondary">Bejegyzést írta: ${permission > 0 ? "<a href=\"?profile&id=" + it.userid + "\">" + it.username + "</a>" : it.username} - ${it.postdate}</small></p>
                                <p>👍: ${it.likecount} darab</p>
                            </div>
                        </div>
                    </div>
                </div>
            `
        }

        for (var it of topics)
        {
            document.getElementById('searchtype').innerHTML += `<option value="${it.id}">${it.name}</option>`
        }
        document.getElementById('searchtype').innerHTML += `<option value="-1" selected>mindegy</option>`
    }

    doSearch = async () => {
        await fetch('api.php?search&title=' + document.getElementById('searchname').value + "&type=" + document.getElementById('searchtype').value).then(async response => {
            const json = await response.json()
            el.childNodes.forEach(element => {
                if (element.classList && element.classList.contains('entry')) el.removeChild(element)
            })

            for (var it of json) {
                el.innerHTML += `
                    <div class="card mb-3 entry">
                        <div class="row g-0">
                            <div class="col-md-2">
                                <img src="scroll.png" class="img-fluid rounded-start">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="?viewpost&id=${it.id}">${it.title}</a> <i>(${it.name})</i></h5>
                                    <p class="card-text">${it.text.replace(/\\n/g, '<br>')}</p>
                                    <p class="card-text"><small class="text-body-secondary">Bejegyzést írta: ${permission > 0 ? "<a href=\"?profile&id=" + it.userid + "\">" + it.username + "</a>" : it.username} - ${it.postdate}</small></p>
                                    <p>👍: ${it.likecount} darab</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }
        })
    }
</script>
