# FixLinkDie

```bash
php main.php > main.log & echo $!;
```

- view log:
```
tail -f main.log -n 10
```

- kill running command
```
ps ax | grep main.php
```
