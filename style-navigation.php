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
    color: #334155;
  }

  .medium-color {
    color: #334155;
  }

  .welcome {
    color: <?php print $highlight ?>;
    font-size: 14px;
    text-align: left;
    font-weight: bold;
  }

  .mobile-menu a {
    font-size: 40px;
    color: red;
  }

  .hide-on-mobile {
    display: inline-block;
  }

  .navigation-menu {
    position: absolute;
    flex: display;
    flex-direction: row;
    top: 20px;
    left: 50%;
    margin-left: -428px;
    padding-left: 30px;
  }

  @media (max-width: 768px) {
    .mobile-menu a {
      font-size: 40px;
      color: red;
    }

    .hide-on-mobile {
      display: none;
    }

    .navigation-menu {
      position: absolute;
      flex: display;
      flex-direction: row;
      top: 20px;
      left: 0;
      margin-left: 0;
    }
  }

  .admin-menu {
    margin-top: 40px;
  }

  .classroom-button {
    color: white;
    padding: 7px 10px;
    letter-spacing: 1px;
    border-radius: 3px;
    font-size: 14px;
  }

  .navigation-mainDiv {
    display: flex;
    justify-content: space-around;
    width: 100%;
  }

  .hamburger {
    display: none;
    padding-right: 30px;
    cursor: pointer;
  }

  .submenu {
    display: flex;
    justify-content: center;
    gap: 20px;
    text-align: center;
  }

  .classroom {
    margin: 30px 0 100px 0;
  }

  .show-menu {
    display: inline;
  }

  .show-button {
    display: block;
  }

  @media (max-width: 768px) {
    .hamburger {
      display: inline-block;
    }

    .submenu,
    .navigation-mainDiv {
      flex-direction: column;
      align-items: flex-end;
    }

    .classroom,
    .hello,
    .submenu,
    .show-button,
    .show-menu {
      display: none;
    }

    .submenu {
      padding: 30px 30px 0 0;
    }

    .submenu * {
      font-size: 30px;
    }

  }
</style>