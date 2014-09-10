<?php 
//header("Content-type: text/html; charset=utf-8"); 
foreach ($news as $news_item): ?>
    <h2><?php echo $news_item['title'] ?></h2>
    <div id="main">
        <?php echo $news_item['text'] ?>
    </div>
    <p><a href="http://localhost/codeigniter/index.php/news/view/<?php echo $news_item['slug'] ?>">View article</a></p>

<?php endforeach ?>
<?php echo $this->benchmark->memory_usage();?>
