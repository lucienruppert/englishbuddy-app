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

  a.white-color,
  a.white-color:link,
  a.white-color:active,
  a.white-color:visited,
  a.white-color:hover,
  .submenu a.white-color,
  .submenu a.white-color:link,
  .submenu a.white-color:active,
  .submenu a.white-color:visited,
  .submenu a.white-color:hover {
    color: #334155 !important;
    text-decoration: none !important;
  }

  a.medium-color,
  a.medium-color:link,
  a.medium-color:active,
  a.medium-color:visited,
  a.medium-color:hover,
  .submenu a.medium-color,
  .submenu a.medium-color:link,
  .submenu a.medium-color:active,
  .submenu a.medium-color:visited,
  .submenu a.medium-color:hover {
    color: #334155 !important;
    text-decoration: none !important;
  }

  /* Override any superfish menu colors */
  .sf-menu a.medium-color,
  .sf-menu a.medium-color:visited,
  .sf-menu a.medium-color:hover,
  .sf-menu a.white-color,
  .sf-menu a.white-color:visited,
  .sf-menu a.white-color:hover {
    color: #334155 !important;
  }

  .welcome {
    color: #334155;
    font-size: 18px;
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
    display: flex;
    flex-direction: row;
    top: 20px;
    left: 50%;
    margin-left: -428px;
    padding-left: 30px;
    gap: 30px;
    font-size: 18px;
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
      display: flex;
      flex-direction: row;
      top: 20px;
      left: 0;
      margin-left: 0;
      gap: 30px;
    }
  }

  .admin-menu {
    margin-top: 40px;
  }

  .classroom-button {
    color: #334155;
    background: white;
    padding: 11.2px 16px;
    letter-spacing: 1px;
    border-radius: 3px;
    font-size: 22.4px;
    border: 2px solid #334155;
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
    display: flex;
    align-items: center;
    justify-content: center;
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