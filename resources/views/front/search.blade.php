<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('output.css') }}" rel="stylesheet" />
    <link href="{{ asset('main.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-[Poppins]">
    <x-navbar />
    <nav id="Category" class="max-w-[1130px] mx-auto flex justify-center items-center gap-4 mt-[30px]">
        @foreach ($categories as $item_category)
            <a href="{{ route('front.category', $item_category->slug) }}"
                class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-[#FF6B18]">
                <div class="w-6 h-6 flex shrink-0">
                    <img src="{{ Storage::url($item_category->icon) }}" alt="icon" />
                </div>
                <span>{{ $item_category->name }}</span>
            </a>
        @endforeach
    </nav>
    <section id="heading" class="max-w-[1130px] mx-auto flex items-center flex-col gap-[30px] mt-[70px]">
        <h1 class="text-4xl leading-[45px] font-bold text-center">
            Explore Hot Trending <br />
            Good article Today
        </h1>
        <form action="{{route('front.search')}}" method="GET"
            class="w-[450px] flex items-center rounded-full border border-[#E8EBF4] p-[12px_20px] gap-[10px] focus-within:ring-2 focus-within:ring-[#FF6B18] transition-all duration-300">

            @csrf
            <button type="submit" class="w-5 h-5 flex shrink-0">
                <img src="{{asset('assets/images/icons/search-normal.svg')}}" alt="icon" />
            </button>
            <input
            autocomplete="off"
            type="text"
            name="keyword"
            id="search-bar"
            class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#A3A6AE]"
            placeholder="Search hot trendy news today..." />
        </form>
    </section>
    <section id="search-result"
        class="max-w-[1130px] mx-auto flex items-start flex-col gap-[30px] mt-[70px] mb-[100px]">
        <h2 class="text-[26px] leading-[39px] font-bold">Search Result: <span>{{ucfirst($keyword)}}</span></h2>
        <div id="search-cards" class="grid grid-cols-3 gap-[30px]">

            @forelse ( $articles as $article)
            <a href="{{route('front.details', $article->slug)}}" class="card">
				<div
					class="flex flex-col gap-4 p-[26px_20px] transition-all duration-300 ring-1 ring-[#EEF0F7] hover:ring-2 hover:ring-[#FF6B18] rounded-[20px] overflow-hidden bg-white">
					<div class="thumbnail-container h-[200px] relative rounded-[20px] overflow-hidden">
						<div
							class="badge absolute left-5 top-5 bottom-auto right-auto flex p-[8px_18px] bg-white rounded-[50px]">
							<p class="text-xs leading-[18px] font-bold">{{$article->user->name}}</p>
						</div>
						<img src="{{asset(Storage::url($article->thumbnail))}}" alt="thumbnail photo"
							class="w-full h-full object-cover" />
					</div>
					<div class="flex flex-col gap-[6px]">
						<h3 class="text-lg leading-[27px] font-bold">{{substr($article->name, 0,70)}}{{strlen($article->name)>50 ? '...' : ''}}</h3>
						<p class="text-sm leading-[21px] text-[#A3A6AE]">{{$article->created_at->format('M d ,Y')}}</p>
					</div>
				</div>
			</a>
            @empty
            <p>Belum ada artikel dengan keyword ini.....</p>
            @endforelse


        </div>
    </section>
</body>

</html>
