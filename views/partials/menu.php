<nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col"><a href="?route=newLink">NewLink</a></div>
            <div class="col"><a href="?route=listLinks">ListLinks</a></div>
            <div class="col"><a href="?route=listTags">ListTags</a></div>
            <div class="col"><a href="?route=toDo">ToDo</a></div>
            <div class="col">
                <form action="?route=addLink" method="post">
                    <label for="link">Ton Lien</label>
                    <input type="text" id="link" name="link">
                    <button type="submit">NewLink</button>
                </form>
            </div>
        </div>
    </div>
</nav>