
<h2>Create a news item</h2>

<?php validation_errors();?>

<?php 
$hidden = array('username' => 'Joe', 'member_id' => '234');
echo form_open('news/create','',$hidden)?>
  <label for="title">Title</label> 
  <input type="input" name="title" /><br />

  <label for="text">Text</label>
  <textarea name="text"></textarea><br />
  <?php echo form_hidden('username', 'johndoe');?>
  <input type = "hidden" name="book" value="css"/>
  <input type="submit" name="submit" value="Create news item" /> 
 </form>