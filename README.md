![Banner](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoLb1hx-nQKuNDj8b5puRRNtDamDvE6Um32Q&usqp=CAU)

## 💀 • Souls

> Souls is the most famous pvp servers plugin and we make them better. We made an advanced plugin with a custom API that you can use to create other plugins, this plugin can manage players in a yml database and add souls to player's personal database when killing another. The plugin includes basic commands to sell souls for money or xp and see total souls.

---

## ⭐ • Planned

> we are planning to add even more features soon to the plugin such as Souls management systems and also an item raffle system with a certain amount of souls clicking on an item that will probably be an end portal... just like in hypixel

---

## 📦 • API

1. To start the development with the plugin API you need create ```plugin.yml``` and set depend:

```yml
name: SkyWars
main: you\plugin\main
version: 1.0.0
api: [4.0.0]
depend: Souls # don't change 
```

2. Now you need to import the plugin API into your ```Main.php``` plugin or other files you are using the API from:

```php
use Minestrap\Souls\Main; # Advanced [Optional]
use Minestrap\Souls\SoulsAPI;
```

3. After that you need to instantiate the plugin API in the plugin function you are using, like ```public function```:

```php
$soulsAPI = new SoulsAPI($this->getPlugin());
```

4. Now you can use the functions to create your custom plugin using this with a controller! General API resources:

```php
// add souls function
$soulsAPI->addSouls($player, $amount);

// remove souls function
$soulsAPI->removeSouls($player, $amount);

// set number of souls
$soulsAPI->setSouls($player, $value);

// view player total souls
$souls = $soulsAPI->getSouls($player);
```

---

> Made with ♥️ by Minestrap.
