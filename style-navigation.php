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

  .logout {
    font-weight: bold;
  }

  A {
    text-decoration: none;
  }

  A:link {
    text-decoration: none;
    color: white;
  }

  A:active {
    text-decoration: none;
    color: white;
  }

  A:visited {
    text-decoration: none;
    color: white;
  }

  A:hover {
    text-decoration: none;
    color: white;
  }

  A.selected {
    text-decoration: none;
    color: white;
  }

  A.selected:link {
    text-decoration: none;
    color: white;
  }

  A.selected:active {
    text-decoration: none;
    color: white;
  }

  A.selected:visited {
    text-decoration: none;
    color: white;
  }

  A.selected:hover {
    text-decoration: none;
    color: white;
  }

  .welcome {
    color: white;
    font-size: 14px;
    text-align: left;
    width: 100%;
    font-weight: bold;
  }
</style>