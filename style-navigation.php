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

  .logout,
  .home {
    color: <?php print $highlight ?>;
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

  .menu-button {
    color: white;
  }

  .menu-button-smaller {
    color: <?php print $colorValue ?>;
    font-weight: normal;
  }

  .welcome {
    color: <?php print $highlight ?>;
    font-size: 14px;
    text-align: left;
    width: 100%;
    font-weight: bold;
  }

  .submenu {
    display: flex;
    justify-content: center;
    gap: 20px;
    width: 100%;
    text-align: center;
  }

  .classroom {
    margin: 30px 0 100px 0;
  }

  .classroom-button {
    color: white;
    padding: 7px 10px;
    letter-spacing: 1px;
    border-radius: 3px;
    font-size: 14px;
  }
</style>