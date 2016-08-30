<table>
  <tr>
    <th>Id</th>
    <th>Title</th>
    <th>Created</th>
  </tr>

  <!-- Here is where we loop through our $posts array, printing out post info -->

  <?php foreach ($posts as $post): ?>
    <tr>
      <td><?php echo $post['Post']['id']; ?></td>
      <td><a href='http://cakephpassignment.com/posts/edit/<?php echo $post['Post']['id'] ?>'>
        <?php echo $post['Post']['title'] ?></a>
      </td>
      <td><?php echo $post['Post']['created']; ?></td>
    </tr>
  <?php endforeach; ?>
  <?php unset($post); ?>
</table>