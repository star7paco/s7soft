package com.s7soft.android.biscuit.calculator;

public class ErrorState implements State {
	private static ErrorState singleton = new ErrorState();

	private ErrorState() { // コンストラクタはprivate
	}

	public static State getInstance() { // 唯一のインスタンスを得る
		return singleton;
	}

	@Override
	public void onInputNumber(Context context, Number num) {
	}

	@Override
	public void onInputOperation(Context context, Operation op) {
	}

	@Override
	public void onInputEquale(Context context) {
	}

	@Override
	public void onInputClear(Context context) {
	}

	@Override
	public void onInputAllClear(Context context) {
		context.clearA();
		context.clearB();
		context.clearDisplay();
		context.clearError();
		context.changeState(NumberAState.getInstance());
	}
}
