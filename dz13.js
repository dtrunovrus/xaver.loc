/* Part 1 */
var $name = "Дмитрий",
    $age = 27;

console.log("Меня зовут " + $name + "\nМне " + $age + " лет");
delete $name;
delete $age;


/* Part 2 */
const MYCITY = "Новосибирск";
if (MYCITY) {
	console.log("MYCITY: " + MYCITY);
}
MYCITY = "Санкт Петербург";

/* Part 3 */
var $book = new Object(null);
$book["title"] = "Ночь Дракона";
$book["author"] = "Ричард А.Кнаак";
$book["pages"] = 500;
console.log("Недавно я прочитал книгу " + $book["title"] +
            ", написанную автором " + $book["author"] + ". " +
            "Я осилил все " + $book["pages"] +
            " страниц. Мне она очень понравилась.");


/* Part 4 */
var $book1 = new Object(null),
    $book2 = new Object(null),
    $books = [];

$book1["title"] = "Круг Ненависти";
$book1["author"] = "Кейт ДеКандидо";
$book1["pages"] = 500;
$books.push($book1);

$book2["title"] = "Душа Демона";
$book2["author"] = "Ричард А.Кнаак";
$book2["pages"] = 500;
$books.push($book2);

console.log("Недавно я прочитал книги " + $books[0]["title"] + " и " + $books[1]["title"] +
     		", написанные соответственно " + $books[0]["author"] + " и " + $books[1]["author"] + ". " +
     		"Я осилил в сумме " + ($books[0]["pages"]+$books[1]["pages"]) +
     		" страниц. Не ожидал от себя такого.");

