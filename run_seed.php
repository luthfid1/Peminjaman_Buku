<?php
require_once __DIR__ . '/config/App.php';
require_once __DIR__ . '/config/Database.php';

$db = Database::getInstance()->getConnection();

$stmt = $db->query("SELECT COUNT(*) as total FROM buku");
$count = $stmt->fetch()->total;
echo "Current book count: " . $count . "\n";

if ($count > 10) {
    echo "Database already has enough books. Skipping seed.\n";
    exit;
}

$books = [
    ['Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia Pustaka Utama', 2009, '978-979-22-4801-1', 4, 1],
    ['Perahu Kertas', 'Dee Lestari', 'Bentang Pustaka', 2009, '978-979-1227-40-8', 3, 1],
    ['Supernova: Ksatria, Puteri, dan Bintang Jatuh', 'Dee Lestari', 'Truedee Books', 2001, '978-979-1227-01-9', 3, 1],
    ['Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 'Republika', 2004, '978-979-3500-10-5', 5, 1],
    ['Ronggeng Dukuh Paruk', 'Ahmad Tohari', 'Gramedia Pustaka Utama', 1982, '978-979-22-0187-0', 2, 1],
    ['Tenggelamnya Kapal Van Der Wijck', 'Hamka', 'Bulan Bintang', 1939, '978-979-416-000-3', 3, 1],
    ['Dilan: Dia Adalah Dilanku Tahun 1990', 'Pidi Baiq', 'Pastel Books', 2014, '978-602-291-005-4', 4, 1],
    ['Hujan', 'Tere Liye', 'Gramedia Pustaka Utama', 2016, '978-602-03-2702-3', 5, 1],
    ['Bumi', 'Tere Liye', 'Gramedia Pustaka Utama', 2014, '978-602-03-0532-8', 4, 1],
    ['Bulan', 'Tere Liye', 'Gramedia Pustaka Utama', 2015, '978-602-03-2166-3', 3, 1],
    ['Matahari', 'Tere Liye', 'Gramedia Pustaka Utama', 2016, '978-602-03-3501-1', 3, 1],
    ['Pulang', 'Tere Liye', 'Republika', 2015, '978-602-0826-51-9', 4, 1],
    ['Sang Pemimpi', 'Andrea Hirata', 'Bentang Pustaka', 2006, '978-979-1227-07-1', 5, 1],
    ['Edensor', 'Andrea Hirata', 'Bentang Pustaka', 2007, '978-979-1227-10-1', 3, 1],
    ['Maryamah Karpov', 'Andrea Hirata', 'Bentang Pustaka', 2008, '978-979-1227-18-7', 2, 1],
    ['Ketika Cinta Bertasbih', 'Habiburrahman El Shirazy', 'Republika', 2007, '978-979-3500-59-4', 4, 1],
    ['5 cm', 'Donny Dhirgantoro', 'Grasindo', 2005, '978-979-759-381-8', 3, 1],
    ['To Kill a Mockingbird', 'Harper Lee', 'J.B. Lippincott & Co.', 1960, '978-0-06-112008-4', 3, 1],
    ['1984', 'George Orwell', 'Secker & Warburg', 1949, '978-0-452-28423-4', 4, 1],
    ['Pride and Prejudice', 'Jane Austen', 'T. Egerton', 1813, '978-0-14-143951-8', 2, 1],
    ['The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 1925, '978-0-7432-7356-5', 3, 1],
    ['One Hundred Years of Solitude', 'Gabriel Garcia Marquez', 'Harper & Row', 1967, '978-0-06-088328-7', 2, 1],
    ['The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 1951, '978-0-316-76948-0', 3, 1],
    ['Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Bloomsbury', 1997, '978-0-7475-3269-9', 5, 1],
    ['The Hobbit', 'J.R.R. Tolkien', 'George Allen & Unwin', 1937, '978-0-618-00221-3', 3, 1],
    ['The Lord of the Rings', 'J.R.R. Tolkien', 'Allen & Unwin', 1954, '978-0-618-64015-7', 2, 1],
    ['Norwegian Wood', 'Haruki Murakami', 'Kodansha', 1987, '978-0-375-70402-4', 3, 1],
    ['Kafka on the Shore', 'Haruki Murakami', 'Shinchosha', 2002, '978-1-4000-7927-8', 2, 1],
    ['The Alchemist', 'Paulo Coelho', 'HarperTorch', 1988, '978-0-06-112241-5', 4, 1],
    ['Siddhartha', 'Hermann Hesse', 'S. Fischer Verlag', 1922, '978-0-553-20884-2', 2, 1],
    ['Filosofi Teras', 'Henry Manampiring', 'Penerbit Buku Kompas', 2018, '978-602-412-453-1', 5, 2],
    ['Atomic Habits', 'James Clear', 'Avery', 2018, '978-0-7352-1129-2', 5, 2],
    ['Thinking, Fast and Slow', 'Daniel Kahneman', 'Farrar, Straus and Giroux', 2011, '978-0-374-27563-1', 3, 2],
    ['Educated', 'Tara Westover', 'Random House', 2018, '978-0-399-59050-4', 4, 2],
    ['Becoming', 'Michelle Obama', 'Crown Publishing Group', 2018, '978-1-5247-6313-8', 3, 2],
    ['The Power of Habit', 'Charles Duhigg', 'Random House', 2012, '978-0-8129-8160-5', 4, 2],
    ['Outliers', 'Malcolm Gladwell', 'Little, Brown and Company', 2008, '978-0-316-01792-3', 3, 2],
    ['Man\'s Search for Meaning', 'Viktor E. Frankl', 'Beacon Press', 1946, '978-0-8070-1426-4', 2, 2],
    ['Quiet: The Power of Introverts', 'Susan Cain', 'Crown Publishing', 2012, '978-0-307-35214-9', 3, 2],
    ['The 7 Habits of Highly Effective People', 'Stephen R. Covey', 'Free Press', 1989, '978-1-9821-3713-2', 4, 2],
    ['Rich Dad Poor Dad', 'Robert Kiyosaki', 'Warner Books', 1997, '978-1-61268-001-6', 5, 2],
    ['How to Win Friends and Influence People', 'Dale Carnegie', 'Simon & Schuster', 1936, '978-0-671-02703-2', 3, 2],
    ['The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'HarperOne', 2016, '978-0-06-245771-4', 4, 2],
    ['Ikigai', 'Hector Garcia & Francesc Miralles', 'Penguin Books', 2017, '978-0-14-313029-1', 5, 2],
    ['Mindset: The New Psychology of Success', 'Carol S. Dweck', 'Ballantine Books', 2006, '978-0-345-47232-8', 3, 2],
    ['Start with Why', 'Simon Sinek', 'Portfolio', 2009, '978-1-59184-280-4', 4, 2],
    ['Grit: The Power of Passion and Perseverance', 'Angela Duckworth', 'Scribner', 2016, '978-1-5011-1110-5', 3, 2],
    ['Deep Work', 'Cal Newport', 'Grand Central Publishing', 2016, '978-1-4555-8666-0', 4, 2],
    ['The Lean Startup', 'Eric Ries', 'Crown Business', 2011, '978-0-307-88789-4', 3, 2],
    ['Sapiens: Grafis Vol. 1', 'Yuval Noah Harari', 'Harvill Secker', 2020, '978-0-06-305104-3', 2, 2],
    ['Cosmos', 'Carl Sagan', 'Random House', 1980, '978-0-345-53943-4', 3, 3],
    ['The Selfish Gene', 'Richard Dawkins', 'Oxford University Press', 1976, '978-0-19-929115-1', 2, 3],
    ['A Short History of Nearly Everything', 'Bill Bryson', 'Broadway Books', 2003, '978-0-7679-0818-4', 4, 3],
    ['The Origin of Species', 'Charles Darwin', 'John Murray', 1859, '978-0-451-52906-0', 2, 3],
    ['Brief Answers to the Big Questions', 'Stephen Hawking', 'Bantam Books', 2018, '978-1-9848-1916-2', 3, 3],
    ['The Gene: An Intimate History', 'Siddhartha Mukherjee', 'Scribner', 2016, '978-1-4767-3352-4', 3, 3],
    ['Astrophysics for People in a Hurry', 'Neil deGrasse Tyson', 'W.W. Norton', 2017, '978-0-393-60939-4', 4, 3],
    ['The Elegant Universe', 'Brian Greene', 'W.W. Norton', 1999, '978-0-393-33810-1', 2, 3],
    ['Silent Spring', 'Rachel Carson', 'Houghton Mifflin', 1962, '978-0-618-24906-0', 3, 3],
    ['The Double Helix', 'James Watson', 'Atheneum', 1968, '978-0-7432-1630-3', 2, 3],
    ['Guns, Germs, and Steel', 'Jared Diamond', 'W.W. Norton', 1997, '978-0-393-31755-8', 4, 3],
    ['The Structure of Scientific Revolutions', 'Thomas S. Kuhn', 'University of Chicago Press', 1962, '978-0-226-45811-3', 2, 3],
    ['Principia Mathematica', 'Isaac Newton', 'Royal Society', 1687, '978-1-60386-435-0', 1, 3],
    ['The Feynman Lectures on Physics', 'Richard Feynman', 'Addison-Wesley', 1964, '978-0-465-02414-8', 3, 3],
    ['Relativity: The Special and General Theory', 'Albert Einstein', 'Henry Holt', 1916, '978-1-891-39642-5', 2, 3],
    ['The Immortal Life of Henrietta Lacks', 'Rebecca Skloot', 'Crown Publishing', 2010, '978-1-4000-5218-9', 3, 3],
    ['Chaos: Making a New Science', 'James Gleick', 'Viking', 1987, '978-0-14-009250-9', 2, 3],
    ['Pale Blue Dot', 'Carl Sagan', 'Random House', 1994, '978-0-345-37659-6', 3, 3],
    ['The Blind Watchmaker', 'Richard Dawkins', 'W.W. Norton', 1986, '978-0-393-31570-7', 2, 3],
    ['What If?', 'Randall Munroe', 'Houghton Mifflin Harcourt', 2014, '978-0-544-27299-6', 4, 3],
    ['Sejarah Nasional Indonesia Jilid 1', 'Marwati Djoened Poesponegoro', 'Balai Pustaka', 2008, '978-979-407-405-5', 3, 4],
    ['Sejarah Nasional Indonesia Jilid 2', 'Marwati Djoened Poesponegoro', 'Balai Pustaka', 2008, '978-979-407-406-2', 3, 4],
    ['Sejarah Nasional Indonesia Jilid 3', 'Marwati Djoened Poesponegoro', 'Balai Pustaka', 2008, '978-979-407-407-9', 3, 4],
    ['Nusantara: Sejarah Indonesia', 'Bernard H.M. Vlekke', 'KPG', 2008, '978-979-91-0206-5', 2, 4],
    ['Jejak Langkah', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1985, '978-979-9731-30-3', 3, 4],
    ['Arus Balik', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1995, '978-979-9731-35-8', 2, 4],
    ['Rumah Kaca', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1988, '978-979-9731-31-0', 2, 4],
    ['Indonesia Etc.: Exploring the Improbable Nation', 'Elizabeth Pisani', 'W.W. Norton', 2014, '978-0-393-35101-8', 3, 4],
    ['The History of Java', 'Thomas Stamford Raffles', 'John Murray', 1817, '978-0-19-580347-1', 1, 4],
    ['Soekarno: An Autobiography', 'Cindy Adams', 'Gunung Agung', 1965, '978-979-407-001-9', 3, 4],
    ['A History of Modern Indonesia', 'Adrian Vickers', 'Cambridge University Press', 2005, '978-0-521-54262-3', 2, 4],
    ['The Fall of the Roman Empire', 'Peter Heather', 'Oxford University Press', 2006, '978-0-19-515954-7', 3, 4],
    ['SPQR: A History of Ancient Rome', 'Mary Beard', 'Profile Books', 2015, '978-1-84668-381-7', 3, 4],
    ['The Silk Roads', 'Peter Frankopan', 'Bloomsbury', 2015, '978-1-4088-3997-3', 4, 4],
    ['1776', 'David McCullough', 'Simon & Schuster', 2005, '978-0-7432-2671-5', 2, 4],
    ['The Rise and Fall of the Third Reich', 'William L. Shirer', 'Simon & Schuster', 1960, '978-0-671-72868-7', 2, 4],
    ['The Second World War', 'Antony Beevor', 'Little, Brown and Company', 2012, '978-0-316-02374-0', 3, 4],
    ['Genghis Khan and the Making of the Modern World', 'Jack Weatherford', 'Crown', 2004, '978-0-609-80964-8', 3, 4],
    ['The Histories', 'Herodotus', 'Penguin Classics', 2003, '978-0-14-044908-2', 1, 4],
    ['A People\'s History of the United States', 'Howard Zinn', 'Harper & Row', 1980, '978-0-06-083865-2', 2, 4],
    ['Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, '978-0-13-235088-4', 5, 5],
    ['The Pragmatic Programmer', 'David Thomas & Andrew Hunt', 'Addison-Wesley', 1999, '978-0-201-61622-4', 4, 5],
    ['Design Patterns', 'Erich Gamma et al.', 'Addison-Wesley', 1994, '978-0-201-63361-0', 3, 5],
    ['Introduction to Algorithms', 'Thomas H. Cormen et al.', 'MIT Press', 2009, '978-0-262-03384-8', 2, 5],
    ['Structure and Interpretation of Computer Programs', 'Harold Abelson & Gerald Sussman', 'MIT Press', 1996, '978-0-262-51087-5', 2, 5],
    ['Artificial Intelligence: A Modern Approach', 'Stuart Russell & Peter Norvig', 'Pearson', 2020, '978-0-13-461099-3', 3, 5],
    ['The Art of Computer Programming Vol. 1', 'Donald Knuth', 'Addison-Wesley', 1968, '978-0-201-89683-1', 1, 5],
    ['Code Complete', 'Steve McConnell', 'Microsoft Press', 2004, '978-0-7356-1967-8', 4, 5],
    ['Refactoring', 'Martin Fowler', 'Addison-Wesley', 2018, '978-0-13-475759-9', 3, 5],
    ['Cracking the Coding Interview', 'Gayle Laakmann McDowell', 'CareerCup', 2015, '978-0-9847828-5-7', 5, 5],
    ['You Don\'t Know JS: Scope & Closures', 'Kyle Simpson', 'O\'Reilly Media', 2014, '978-1-4493-3558-8', 3, 5],
    ['Learning Python', 'Mark Lutz', 'O\'Reilly Media', 2013, '978-1-4493-5573-9', 4, 5],
    ['JavaScript: The Good Parts', 'Douglas Crockford', 'O\'Reilly Media', 2008, '978-0-596-51774-8', 3, 5],
    ['PHP & MySQL: Novice to Ninja', 'Tom Butler & Kevin Yank', 'SitePoint', 2017, '978-0-9943469-8-9', 4, 5],
    ['Head First Design Patterns', 'Eric Freeman & Elisabeth Robson', 'O\'Reilly Media', 2004, '978-0-596-00712-6', 3, 5],
    ['The Mythical Man-Month', 'Frederick P. Brooks Jr.', 'Addison-Wesley', 1975, '978-0-201-83595-3', 2, 5],
    ['Computer Networking: A Top-Down Approach', 'James Kurose & Keith Ross', 'Pearson', 2016, '978-0-13-359414-0', 3, 5],
    ['Operating System Concepts', 'Abraham Silberschatz et al.', 'Wiley', 2018, '978-1-119-32091-3', 2, 5],
    ['Database System Concepts', 'Abraham Silberschatz et al.', 'McGraw-Hill', 2019, '978-0-07-802215-9', 3, 5],
    ['Eloquent JavaScript', 'Marijn Haverbeke', 'No Starch Press', 2018, '978-1-59327-950-9', 4, 5],
    ['Python Crash Course', 'Eric Matthes', 'No Starch Press', 2019, '978-1-59327-928-8', 5, 5],
    ['The C Programming Language', 'Brian Kernighan & Dennis Ritchie', 'Prentice Hall', 1988, '978-0-13-110362-7', 2, 5],
    ['Automate the Boring Stuff with Python', 'Al Sweigart', 'No Starch Press', 2019, '978-1-59327-992-9', 4, 5],
    ['Pro Git', 'Scott Chacon & Ben Straub', 'Apress', 2014, '978-1-4842-0076-6', 3, 5],
    ['Docker Deep Dive', 'Nigel Poulton', 'Independently Published', 2020, '978-1-5218-2235-0', 3, 5],
];

$insertStmt = $db->prepare("INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, jumlah_stok, kategori_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

$inserted = 0;
$errors = 0;

foreach ($books as $book) {
    try {
        $insertStmt->execute($book);
        $inserted++;
    } catch (PDOException $e) {
        $errors++;
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Inserted: $inserted\n";
echo "Errors: $errors\n";

$stmt2 = $db->query("SELECT COUNT(*) as total FROM buku");
echo "Total books now: " . $stmt2->fetch()->total . "\n";
