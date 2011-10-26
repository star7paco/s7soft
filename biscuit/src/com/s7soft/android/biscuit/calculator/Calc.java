package com.s7soft.android.biscuit.calculator;

import android.widget.TextView;
import android.widget.Toast;

public class Calc implements Context {

	private double A;// 電卓はメモリAを持ちます。

	private double B;// 電卓はメモリBを持ちます。

	private Operation op;// 電卓は演算子を持ちます。

	protected AbstractDisplay disp; // 電卓はディスプレイを持ちます。

	protected State state; // 電卓の状態を表すクラス

	protected android.content.Context parent; // Toast表示用にcontextを持ちます。

	public Calc() {
		A = 0d;
		B = 0d;
		op = null;
		changeState(NumberAState.getInstance());
	}

	public void setDisp(TextView txt,android.content.Context parent){
		this.disp = new StringDisplay(txt);
		this.parent = parent;
	}

	public void onButtonNumber(Number num) {
		state.onInputNumber(this, num);
	}

	public void onButtonOp(Operation op) {
		state.onInputOperation(this, op);
	}

	public void onButtonClear() {
		state.onInputClear(this);
	}

	public void onButtonAllClear() {
		state.onInputAllClear(this);
	}

	public void onButtonEquale() {
		state.onInputEquale(this);
	}

	@Override
	public void addDisplayNumber(Number num) {

		if (num == Number.ZERO || num == Number.DOUBLE_ZERO) {
			if (disp.displayChar.size() == 0 && !disp.commaMode) {
				disp.showDisplay(false);
				return;
			}
		}

		if (num == Number.COMMA && !disp.commaMode && disp.displayChar.size() == 0) {
			disp.onInputNumber(Number.ZERO);
		}

		disp.onInputNumber(num);
		disp.showDisplay(false);

	}

	@Override
	public void clearDisplay() {
		disp.clear();
		disp.showDisplay(false);
	}

	@Override
	public void clearA() {
		A = 0d;

	}

	@Override
	public void clearB() {
		B = 0d;
	}

	@Override
	public double doOperation() throws CalcException{
		double result = op.eval(A, B);

		// Doubleの場合、ゼロ割でエラーが発生しないので注意が必要。
		if (Double.isInfinite(result) || Double.isNaN(result)) {
			throw new CalcException();
		}

		showDisplay(result);

		// 演算結果がディスプレイからはみ出ないかチェック
		if (disp.isOverflow(result)) {
			throw new CalcException();
		}

		return result;
	}

	@Override
	public void saveDisplayNumberToA() {
		A = disp.getNumber();

	}

	@Override
	public void saveDisplayNumberToB() {
		B = disp.getNumber();

	}

	@Override
	public void showDisplay() {

		disp.showDisplay(false);

	}

	@Override
	public void showDisplay(double d) {
		disp.setNumber(d);
		disp.showDisplay(true);

	}

	@Override
	public Operation getOp() {
		return op;
	}

	@Override
	public void setOp(Operation op) {
		this.op = op;
	}

	public double getA() {
		return A;
	}

	public double getB() {
		return B;
	}

	@Override
	public void changeState(State state) {
		this.state = state;
	}

	@Override
	public void copyAtoB() {
		B = A;
	}

	@Override
	public void clearError() {
		disp.clearError();

	}

	@Override
	public void setError() {
		if (parent != null){
			Toast.makeText(parent, "ERROR", Toast.LENGTH_LONG).show();
		}
		disp.setError();
	}

	@Override
	public void changeSign() {
		if (disp.getNumber() != 0d) {
			disp.minus = !disp.minus;
			disp.showDisplay(false);
		}
	}

	public double getValue(){
		return disp.getNumber();
	}

}
