#ifndef WIN32_LEAN_AND_MEAN
#define WIN32_LEAN_AND_MEAN
#endif
#include <Windows.h>
#include <cmath>
#include <thread>
#include <tchar.h>
#include <string>
using namespace std;

int curX, curY;
bool crazyMouse;
void CrazyMouse() {
	while (crazyMouse) {
		curX = rand() % (int)GetSystemMetrics(SM_CXSCREEN);
		curY = rand() % (int)GetSystemMetrics(SM_CYSCREEN);
		SetCursorPos(curX, curY);
	}
}

int freq, dur;
bool beeper;
void Beeper() {
	while (beeper) {
		freq = rand() % 2001;
		dur = rand() % 301;
		Beep(freq, dur);
	}
}

const LPCWSTR BSOD_TEXT = L"A fatal exception 0E occured at 0028:C003CC2F in VXD VMM(01) +\n 0000156B. The current application will be terminated.\n\n\t* Press any key to terminate the current application.\n\t* Press CTRL+ALT+DEL again to restart your computer. You will\nlose any unsaved information in all applications.\n";

void PaintBSOD(HDC hdc, HWND hwnd) {
	SetBkMode(hdc, TRANSPARENT);
	SetTextColor(hdc, RGB(255, 255, 255));

	RECT rc;
	

	GetWindowRect(hwnd, &rc);


	/* int rectHeight = DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &rc, DT_CALCRECT);                    // Get formating rectangle height

	int windowHight = rc.bottom - rc.top;
	int windowWidth = rc.right - rc.left;


	int yTop = rc.top + ((windowHight - rectHeight) / 2);
	int yBottom = yTop + rectHeight;

	int xLeft = rc.left + 20;
	int xRight = rc.right - 20;


	rc.top = (int)GetSystemMetrics(SM_CYSCREEN)/2-rectHeight/2;
	rc.bottom = 0;
	rc.left = 0;
	rc.right = 0; */


	DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &rc, NULL);
}

void MakeBSOD(HWND hwnd) {
	HDC hdc;
	PAINTSTRUCT ps;
	hdc = BeginPaint(hwnd, &ps);

	RECT title;
	GetWindowRect(hwnd, &title);
	title.top = 100;
	DrawText(hdc, TEXT(" Windows "), strlen(" Windows "), &title, DT_CENTER);

	
	SetBkMode(hdc, TRANSPARENT);
	SetTextColor(hdc, RGB(255, 255, 255));

	RECT rc;
	GetWindowRect(hwnd, &rc);


	int rectHeight = DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &rc, DT_CALCRECT);

	int windowHight = rc.bottom - rc.top;
	int windowWidth = rc.right - rc.left;


	int yTop = rc.top + ((windowHight - rectHeight) / 2);
	int yBottom = yTop + rectHeight;

	int xLeft = rc.left + 20;
	int xRight = rc.right - 20;


	rc.top = yTop;
	rc.bottom = yBottom;
	rc.left = xLeft;
	rc.right = xRight;

	DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &rc, NULL);

	EndPaint(hwnd, &ps);
}


// WndProc - Window procedure
LRESULT CALLBACK WndProc(HWND hWnd, UINT uMsg, WPARAM wParam, LPARAM lParam) {
	switch (uMsg) {
		case WM_DESTROY:
			PostQuitMessage(0);
			break;
		case WM_PAINT:
			MakeBSOD(hWnd);
			break;
		default:
			return ::DefWindowProc(hWnd, uMsg, wParam, lParam);
	}

	return 0;
}

int GenerateWindow(HINSTANCE hInstance) {
	// Setup window class attributes.
	WNDCLASSEX wcex;
	ZeroMemory(&wcex, sizeof(wcex));

	wcex.cbSize = sizeof(wcex);
	wcex.style = CS_HREDRAW | CS_VREDRAW;
	wcex.lpszClassName = TEXT("WINCLASS");
	wcex.hbrBackground = CreateSolidBrush(RGB(0, 0, 170));
	wcex.hCursor = LoadCursor(NULL, IDC_ARROW);
	wcex.lpfnWndProc = WndProc;
	wcex.hInstance = hInstance;

	// Register window and ensure registration success.
	if (!RegisterClassEx(&wcex))
		return 1;

	// Setup window initialization attributes.
	CREATESTRUCT cs;
	ZeroMemory(&cs, sizeof(cs));

	cs.x = 0;
	cs.y = 0;
	cs.cx = (int)GetSystemMetrics(SM_CXSCREEN);
	cs.cy = (int)GetSystemMetrics(SM_CYSCREEN);
	cs.hInstance = hInstance;
	cs.lpszClass = wcex.lpszClassName;
	cs.style = WS_POPUP;

	HWND hWnd = ::CreateWindowEx(
		cs.dwExStyle,
		cs.lpszClass,
		cs.lpszName,
		cs.style,
		cs.x,
		cs.y,
		cs.cx,
		cs.cy,
		cs.hwndParent,
		cs.hMenu,
		cs.hInstance,
		cs.lpCreateParams);

	ShowCursor(false);

	// Validate window.
	if (!hWnd)
		return 1;

	// Display the window.
	::ShowWindow(hWnd, SW_SHOWDEFAULT);
	::UpdateWindow(hWnd);

	// Main message loop.
	MSG msg;
	while (::GetMessage(&msg, hWnd, 0, 0) > 0)
		::DispatchMessage(&msg);

	// Unregister window class, freeing the memory that was
	// previously allocated for this window.
	::UnregisterClass(wcex.lpszClassName, hInstance);
	return (int)msg.wParam;
}

// WinMain - Win32 application entry point.
int APIENTRY wWinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPWSTR lpCmdLine, int nShowCmd) {
	//Sleep(2 * 1000);

	/*crazyMouse = true;
  thread mouse(CrazyMouse);

  beeper = true;
  thread beep(Beeper);

  Sleep(1000);

  crazyMouse = false;
  beeper = false;
  mouse.join();
  beep.join();
	*/

	return GenerateWindow(hInstance);
}
