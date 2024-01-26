<style>
  .navigation {
    font-size: 14px;
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    padding: 20px 20px;
    <?php if ($userObject) { ?>border-bottom: 1px solid <?php print $highlight ?>;
    <?php } ?>
  }

  .logout, .home {
    color: <?php print $highlight ?>;
  }

  .menu-button {
    color: white;
  }

  A,
  A:link,
  A:active,
  A:visited,
  A:hover,
  A.selected,
  A.selected:link,
  A.selected:active,
  A.selected:visited {
    text-decoration: none;
  }

  .welcome {
    color: <?php print $highlight ?>;
    font-size: 14px;
    text-align: left;
    width: 100%;
    font-weight: bold;
  }
</style>