<style>
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

  .white-color {
    color: white;
  }

  .medium-color {
    color: <?php print $colorValue ?>;
  }

  .welcome {
    color: <?php print $highlight ?>;
    font-size: 14px;
    text-align: left;
    font-weight: bold;
  }

  .navigation-mainDiv {
    display: flex;
    justify-content: space-around;
    width: 100%;
  }

  .navigation-menu {
    position: absolute;
    flex: display;
    flex-direction: row;
    top: 20px;
    left: 50%;
    margin-left: -428px;
  }

  .navigation-menu * {
    padding-left: 30px;
  }

  .submenu {
    display: flex;
    justify-content: center;
    gap: 20px;
    text-align: center;
  }

  .admin-menu {
    margin-top: 40px;
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