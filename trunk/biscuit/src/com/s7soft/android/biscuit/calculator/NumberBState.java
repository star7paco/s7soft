package com.s7soft.android.biscuit.calculator;

public class NumberBState implements State {

	private static NumberBState singleton = new NumberBState();

	private NumberBState() { // コンストラクタはprivate
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
		try {
			context.saveDisplayNumberToB();
			context.doOperation();
			context.setOp(op);
			context.saveDisplayNumberToA();
			context.changeState(OperationState.getInstance());
		} catch (CalcException e) {
			context.setError();
			context.changeState(ErrorState.getInstance());
		}
	}

	@Override
	public void onInputEquale(Context context) {
		try {
			context.saveDisplayNumberToB();
			context.doOperation();
			context.changeState(ResultState.getInstance());
		} catch (CalcException e) {
			context.setError();
			context.changeState(ErrorState.getInstance());
		}
	}

	@Override
	public void onInputClear(Context context) {
		context.clearB();
		context.clearDisplay();
	}

	@Override
	public void onInputAllClear(Context context) {
		context.clearA();
		context.clearB();
		context.clearDisplay();

		context.changeState(NumberAState.getInstance());
	}

}
