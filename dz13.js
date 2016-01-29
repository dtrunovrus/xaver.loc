/* Part 1 */
var name = "Дмитрий",
    age = 27;

console.log("Меня зовут " + name + "\nМне " + age + " лет");
delete $name;
delete $age;


/* Part 2 */
var MYCITY = "Новосибирск";
if (MYCITY) {
	console.log("MYCITY: " + MYCITY);
}
//MYCITY = "Санкт Петербург";

/* Part 3 */
var book = {};
book.title = "Ночь Дракона";
book.author = "Ричард А.Кнаак";
book.pages = 500;
console.log("Недавно я прочитал книгу " + book.title +
            ", написанную автором " + book.author + ". " +
            "Я осилил все " + book.pages +
            " страниц. Мне она очень понравилась.");


/* Part 4 */
var book1 = {title:"Круг Ненависти", author: "Кейт ДеКандидо", pages: 500},
    book2 = {title:"Душа Демона", author: "Ричард А.Кнаак", pages: 500},
    books = [];

books.push(book1);
books.push(book2);

console.log("Недавно я прочитал книги " + books[0].title + " и " + books[1].title +
     		", написанные соответственно " + books[0].author + " и " + books[1].author + ". " +
     		"Я осилил в сумме " + (books[0].pages+books[1].pages) +
     		" страниц. Не ожидал от себя такого.");

