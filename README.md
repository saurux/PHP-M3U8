# PHP-M3U8
## M3U8 Stream Video Downloader
###### Usage

Getting Files
```
if(Master::GetResolution() && Master::GetFiles()) {
	Master::PrintDebug();
}
```

Download Videos
```
if(Master::GetResolution() && Master::GetFiles()) {
	$Target = Master::Get('files');		// 1920x1080
	if(Master::Start($Target[3])) {
		echo "Download - Completed";
	}
}
```