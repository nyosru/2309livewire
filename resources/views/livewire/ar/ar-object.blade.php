<div
    wire:click="switchShowInfo"
    class="ar_object"
    x-data="{ tab: 'payments' }">

    <div class="head text-3xl pay-in-month {{ $object->pay_in_month ? 'pay-yes bg-green-300 hover:bg-green-500' : 'pay-no bg-yellow-200 hover:bg-yellow-300 ' }} p-2">

        <button class="px-2 py-0 my-0 text-[12px] float-right text-black-200 hover:bg-red-300 hover:text-black-800"
                wire:click="delete"
                wire:confirm="Удалить ?">
            X
        </button>

        @if($deleted)
            <span class="float-left">Удалено</span>
        @else

            <livewire:ar.peopleAddForm :now_object="$object->id"/>
            <abbr title="Самый Свежий платёж" class="float-right text-[12px] bg-cyan-200 my-0 py-[0px] px-1"
                  style="line-height: 20px;">{{ $object->last_pay->date ?? '-' }}</abbr>

        @endif

        <span>
        <livewire:helper.showerDopInfo
            :string="'#'.$object->nomer .' / '.$object->adres"
            :data="$object->getAttributes()"
        />
        </span>

{{--        <span class="text-[1rem] float-right">--}}
{{--        <button wire:click="switchShowInfo">switchShowInfo</button>--}}
{{--        switchShowInfo: {{$show_info ? 1:2}}--}}
{{--        </span>--}}

    </div>

    @if( $show_info )
    <!-- Tab Content for Each Tenant -->
    @foreach($object->prices as $price)
        <div class="w-full md:w-[48%] float-left mb-3 mr-[1%] tenant-card mt-4 border border-gray-300 rounded-md p-4">
            <div class="tenant-header flex justify-between">
                <div>
                    <h3 class="text-xl font-semibold">{{ $price->man[0]->name }}
                        <abbr title="Старт число"
                              class="text-[0.8rem] bg-blue-100 px-2 py-1">Старт {{ date('d',strtotime($price->date_start)) }}</abbr>
                        {{--                    <pre>{{ print_r( [$price->date], true ) }}</pre>--}}
                        {{--                    <pre>{{ print_r( [$price], true ) }}</pre>--}}
                        {{--                    <sup>{{ date('d.m',strtotime($price->date)) }}</sup>--}}
                    </h3>

                    <p class="text-sm text-gray-500">{{ $price->man[0]->phone }}</p>
                </div>
                <div class="tab-buttons">
                    <button @click="tab = 'payments'" :class="{ 'bg-gray-200': tab === 'payments' }" class="px-4 py-2">
                        Платежи
                    </button>
                    <button @click="tab = 'comments'" :class="{ 'bg-gray-200': tab === 'comments' }" class="px-4 py-2">
                        Комментарии
                    </button>
                </div>
            </div>

            <!-- Tab Content for Payments -->
            <div x-show="tab === 'payments'">
                @if(!empty($price->man[0]->payes))
                    <livewire:ar.pay-add-form
                        :object_id="$object->id"
                        :people_id="$price->man[0]->id"
                        :amount="round($price->price)"
                    />

                    <div style="max-height: 150px; overflow: auto; border: 1px solid cyan;" class="p-2 mt-4">
                        @foreach($price->man[0]->payes as $pay)
                            <livewire:ar.pay :pay="$pay"/>
                        @endforeach
                    </div>
                @else
                    <p>Нет платежей.</p>
                @endif
            </div>

            <!-- Tab Content for Comments -->
            <div x-show="tab === 'comments'" class="mt-4">
                <livewire:ar.ar-comment-form
                    :ar_object_id="$object->id"
                    :ar_people_id="$price->man[0]->id ?? null"
                />

                <div class="comments-list mt-4">
                    @forelse($price->man[0]->comments as $comment)
                        <div class="comment border p-2 mb-2 rounded-md shadow-sm">
                            <p><strong>Комментарий:</strong> {{ $comment->comment }}</p>
                            <p><small>Создано: {{ $comment->created_at->format('d.m.Y H:i') }}</small></p>
                        </div>
                    @empty
                        <p>Нет комментариев.</p>
                    @endforelse

                    {{--                    {{ $price->man[0]->comments->links() }} <!-- Для пагинации -->--}}
                    {{--                    {{ $comments->links() }}--}}
                </div>
            </div>
        </div>
    @endforeach
    <br clear="all"/>
    @endif
</div>
