package com.s7soft.android.biscuit.calculator;

public class OperationState implements State {

	private static OperationState singleton = new OperationState();

	private OperationState() { // コンストラクタはprivate
	}

	public static State getInstance() { // 唯一のインスタンスを得る
		return singleton;
	}

	@Override
	public void onInputNumber(Context context, Number num) {

		context.clearDisplay();
		context.addDisplayNumber(num);

		context.changeState(NumberBState.getInstance());

	}

	@Override
	public void onInputOperation(Context context, Operation op) {
		context.setOp(op);
	}

	@Override
	public void onInputEquale(Context context) {
			switch (context.getOp()) {
			case DIVIDE:
			case TIMES:
				try{
					context.copyAtoB();
					context.doOperation();
					context.changeState(ResultState.getInstance());
				} catch (CalcException e) {
					context.setError();
					context.changeState(ErrorState.getInstance());
				}
				break;
			case MINUS:
			case PLUS:
				context.showDisplay(context.getA());
				context.changeState(ResultState.getInstance());
				break;
			default:
				break;
			}

	}

	@Override
	public void onInputClear(Context context) {
		context.clearA();
		context.clearDisplay();
		context.changeState(NumberAState.getInstance());
	}

	@Override
	public void onInputAllClear(Context context) {
		context.clearA();
		context.clearB();
		context.clearDisplay();
		context.changeState(NumberAState.getInstance());
	}
}
