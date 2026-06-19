linter:
	@echo "делаем линтер (найдёт всё и поправит)"
	@sleep 3
	 ./vendor/bin/pint

linter-show:
	@echo "смотрим что линтер видит (проверяет показывает косяки, без правок)"
	@sleep 3
	 ./vendor/bin/pint -v

linter-file-show:
	@echo "смотрим что линтер видит в 1 файле (без правок): $(FILE)"
	@sleep 3
	 ./vendor/bin/pint -v $(FILE)

linter-file-fix:
	@echo "правим линтером 1 файл: $(FILE)"
	@sleep 3
	 ./vendor/bin/pint $(FILE)

bash:
	docker exec -it 2309livewire bash

tailwind:
	docker exec 2309livewire npm install -g npx
	docker exec -it 2309livewire npx tailwindcss -i ./resources/css/app.css -o ./public/css/output.css --watch
