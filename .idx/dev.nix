{pkgs}: {
  channel = "stable-23.11";
  packages = [
    pkgs.nodejs_20
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.phpunit
  ];
  idx.previews = {
    previews = {
      web = {
        command = [
          "php"
          "artisan"
          "serve"
        ];
        manager = "web";
      };
    };
  };
}