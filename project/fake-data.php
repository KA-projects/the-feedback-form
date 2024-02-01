<!-- $fakeData = [
                [
                    'Name' => 'Emily Johnson',
                    'Email' => 'emily.johnson@example.com',
                    'Text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vestibulum augue vel metus tristique, ac commodo neque aliquam.',
                ],
                [
                    'Name' => 'Alex Smith',
                    'Email' => 'alex.smith@example.com',
                    'Text' => 'Fusce vehicula, dolor sit amet consectetur sagittis, elit ante congue dolor, a cursus purus dui nec justo.',
                ],
                [
                    'Name' => 'Jessica Miller',
                    'Email' => 'jessica.miller@example.com',
                    'Text' => 'Proin sed eros eu purus sodales congue a ut est. Integer commodo fringilla odio a rhoncus.',
                ],
                [
                    'Name' => 'Ethan Brown',
                    'Email' => 'ethan.brown@example.com',
                    'Text' => 'Quisque in elit quis nisl scelerisque fermentum. Nulla facilisi. Integer at lacus dapibus, varius orci non, malesuada ex.',
                ],
                [
                    'Name' => 'Olivia Davis',
                    'Email' => 'olivia.davis@example.com',
                    'Text' => 'Mauris in felis in lectus auctor tincidunt. Curabitur feugiat, velit ac accumsan varius, urna ex tristique metus.',
                ],
                [
                    'Name' => 'Noah Taylor',
                    'Email' => 'noah.taylor@example.com',
                    'Text' => 'Aenean efficitur turpis a nunc cursus, id facilisis neque condimentum. Suspendisse potenti. Nunc eget fermentum nulla.',
                ],
                [
                    'Name' => 'Sophia Wilson',
                    'Email' => 'sophia.wilson@example.com',
                    'Text' => 'Sed tristique eros eget fringilla tristique. Duis vel dapibus mauris, eu ultricies est. Sed euismod, libero id hendrerit.',
                ],
                [
                    'Name' => 'Mason Jones',
                    'Email' => 'mason.jones@example.com',
                    'Text' => 'Vivamus eu quam a elit interdum accumsan. Sed fringilla dui non mauris varius, vitae aliquet sem malesuada.',
                ],
                [
                    'Name' => 'Ava White',
                    'Email' => 'ava.white@example.com',
                    'Text' => 'Aliquam erat volutpat. Maecenas ut libero vel arcu fermentum venenatis sit amet eget dolor.',
                ],
                [
                    'Name' => 'Jackson Thomas',
                    'Email' => 'jackson.thomas@example.com',
                    'Text' => 'Pellentesque scelerisque odio eu sapien ultrices, sit amet egestas nulla imperdiet. Etiam ut metus sed mi blandit mattis.',
                ],

            ];

            foreach ($fakeData as $item) {
                // Generate fake data from the array
                $name = $item['Name'];
                $email = $item['Email'];
                $text = $item['Text'];
                $date = date("Y-m-d H:i:s");
                $status = 'awaited'; // Default status
                $changedByAdmin = 'no'; // Default state

                // Prepare and execute the query
                $stmt = $db->prepare("INSERT INTO $table (name, email, text, date, status, changedByAdmin) VALUES (:name, :email, :text, :date, :status, :changedByAdmin)");

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':changedByAdmin', $changedByAdmin);

                $stmt->execute();

                $count += $stmt->rowCount();
            } -->