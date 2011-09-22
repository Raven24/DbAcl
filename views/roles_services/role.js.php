var newContent = $(<?= encode_javascript(partial('roles_services/_role.html.php', array('role'=>$role))) ?>);
$('.role[data-id=<?= $role['rid'] ?>]')
  .html(newContent.html())
  .data('containing', newContent.data('containing'))
  .find('span.service').css('cursor','move').draggable(dragDefaults);
hideOverlay();