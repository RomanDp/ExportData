## Построение отчетов

### Терминология

**Входные параметры** (`GenerationRequest`) - какие-то параметры, на основании которых нужно строить отчет. Например, это какая-то дата или несколько дат

**Сгенерированный отчет** (`GeneratedReport`) - модель сгенерированного отчета, по сути это представление таблицы. Состоит из строк (`Row`), каждая из которых, в свою очередь, состоит из ячеек (`Cell`). В ячейках находятся данные `value` (текст, цифры, ...), ячейки имеют свое предназначение `purpose` (заголосок отчета, заголовок колонки, ...), могут занимать несколько колонок и/или строк в случае, если `colspan > 1` и/или `rowspan > 1` соответственно.

**Данные** (`ReportSource`) - саггрегированные данные, по которым удобно строить *сгенерированный отчет*.

**Источник данных** (`ReportSourceProvider`) - источник данных, для генерации отчета. На основании *входных параметров* выдает *данные*, по которым дальше будет генерироваться отчет. Обычно тут происходит обращение к БД через репозитории

**Рендерер** (`Renderer`) - трансформер, который преобразовывает *сгенерированный отчет* в файл (html, xlsx, ...).
