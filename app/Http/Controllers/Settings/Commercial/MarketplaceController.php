<?php

namespace App\Http\Controllers\Settings\Commercial;

use App\DTOs\Settings\Commercial\Marketplaces\RuleDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\Commercial\Marketplaces\StoreNewRuleRequest;
use App\Services\Settings\Commercial\ChannelsServices;
use App\Services\Settings\Commercial\RuleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function __construct(
        private readonly ChannelsServices $channelsServices,
        private readonly RuleService $ruleService
    )
    {}
    public function storeModalCreateNewRule(StoreNewRuleRequest $request): JsonResponse
    {
        try {

            $channel = $this->ruleService
                ->store(new RuleDto(...$request->validated()));

            return response()->json([
                'success' => true,
                'channel' => $channel,
            ]);

        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }

    }
    public function openModalCreateNewRule(): JsonResponse
    {
        $channels = $this->channelsServices->channels();

        $view = view('panel.settings.commercial.marketplaces.modals.createNewRule',
            compact('channels'))
            ->render();

        return response()
            ->json(['view' => $view], 200);
    }
    public function index(): View
    {
        return view('panel.settings.commercial.marketplaces.index');
    }
}
