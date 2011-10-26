package com.s7soft.android.biscuit.calculator;

public class NumberAState implements State {

	private static NumberAState singleton = new NumberAState();

	private NumberAState() { // コンストラクタはprivate
	}

	public static State getInstance() { // 唯一のインスタンスを得る
		return singleton;
	}

	@Override
	public void onInputNumber(Context context, Number num) {
		context.addDisplayNumber(num);

	}

	@Override
	public void onInputOperation(Context context, Operation op) {
		context.saveDisplayNumberToA();
		context.setOp(op);
		context.changeState(OperationState.getInstance());// 次の状態

	}

	@Override
	public void onInputEquale(Context context) {
		context.saveDisplayNumberToA();
		context.showDisplay(context.getA());
		context.changeState(ResultState.getInstance());

	}

	@Override
	public void onInputClear(Context context) {
		context.clearA();
		context.clearDisplay();
	}

	@Override
	public void onInputAllClear(Context context) {
		context.clearA();
		context.clearB();
		context.clearDisplay();

	}
}
