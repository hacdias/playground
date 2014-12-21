begin
	integer = /^[-+]?\d+$/
	float = /^[-+]?\d+\.\d+/
	array = /^\[.+\]$/

	def found_a(something, input, an: false)
		found = if an
			'Found an '
		else
			'Found a '
		end

		puts found + something + ': ' + input
	end

	puts
	puts "Hello, human!"
	puts
	puts "Welcome to 'Type Finder' console app, version 0.1 . Just type something and I will return to you the type of each word that you have sent."
	puts
	puts "I'm not human, but I understant you so, if you want to leave just type 'exit' and I go out. Now, just type and be happy!"
	

	loop do 

		puts
		input = gets.chomp
		puts

		if input == 'exit'
			puts 'Bye!'
			exit!
		elsif input.match(array)
			found_a 'array', input, an: true
		else
			input = input.split(" ")

			for i in 0...input.length

				loop do

					if input[i] == 'true' || input[i] == 'false'
						found_a 'boolean value', input[i]
						break
					end

					if input[i].match(float)
						found_a 'floating-point number', input[i]
						break
					end

					if input[i].match(integer)
						found_a 'integer number', input[i]
						break
					end

					if input[i].match(array)
						found_a 'array', input[i], an: true
						break
					end

					found_a 'string', input[i]
					break
				end


			end	
		end
	end

rescue Interrupt
	puts "Bye"
rescue Exception => e
	puts e
end