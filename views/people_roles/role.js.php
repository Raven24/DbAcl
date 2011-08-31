var newContent = $(<?= encode_javascript(partial('people_roles/_role.html.php', array('role'=>$role))) ?>);
$('.role[data-id=<?= $role['rid'] ?>]')
  .html(newContent.html())
  .data('containing', newContent.data('containing'))
  .find('span.person').css('cursor','move').draggable({
    revert: 'invalid',
    opacity: 0.7,
    helper: "clone"
  });
hideOverlay();